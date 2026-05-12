<?php
namespace App\Controllers;

use App\Models\TransactionModel;
use App\Models\AgencesModel;
use App\Models\OperateursModel;
use App\Models\OperateurNumerosModel;
use App\Models\ClientModel;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use Dompdf\Dompdf;


class Transactions extends SecureBaseController
{
    protected $transactionModel;
    protected $agenceModel;
    protected $operateurModel;
    protected $operateurNumeroModel;
    protected $clientModel;

    public function __construct()
    {
         parent::__construct(); // 🔹 Vérifie la session utilisateur
        $this->transactionModel = new TransactionModel();
        $this->agenceModel = new AgencesModel();
        $this->operateurModel = new OperateursModel();
        $this->operateurNumeroModel = new OperateurNumerosModel();
        $this->clientModel = new ClientModel();
    }
    public function print($id)
{
    $transaction = $this->transactionModel
        ->select('transactions.*, users.username AS agent, agences.nom AS agence, clients.nom AS client_nom, clients.telephone AS client_telephone')
        ->join('users', 'users.id = transactions.user_id', 'left')
        ->join('agences', 'agences.id = transactions.agence_id', 'left')
        ->join('clients', 'clients.id = transactions.client_id', 'left')
        ->where('transactions.id', $id)
        ->first();

    if (!$transaction) {
        return redirect()->back()->with('error', 'Transaction introuvable');
    }


    // Générer PDF
    $dompdf = new Dompdf();

    $html = view('transactions/print_ticket', ['transaction' => $transaction]);
    $dompdf->loadHtml($html);
    $dompdf->setPaper([0, 0, 250, 600]); // Taille type ticket
    $dompdf->render();
    $dompdf->stream("ticket_{$transaction['id']}.pdf", ['Attachment' => 0]);
}
// -----------------------------
// Télécharger ticket PDF
// -----------------------------
public function download($id)
{
    $transaction = $this->transactionModel
        ->select('transactions.*, users.username AS agent, agences.nom AS agence, 
                  operateurs.nom AS operateur, operateur_numeros.numero AS operateur_numero, 
                  clients.nom AS client_nom, clients.telephone AS client_telephone')
        ->join('users', 'users.id = transactions.user_id', 'left')
        ->join('agences', 'agences.id = transactions.agence_id', 'left')
        ->join('operateur_numeros', 'operateur_numeros.id = transactions.operateur_numero_id', 'left')
        ->join('operateurs', 'operateurs.id = operateur_numeros.operateur_id', 'left')
        ->join('clients', 'clients.id = transactions.client_id', 'left')
        ->where('transactions.id', $id)
        ->first();

    if(!$transaction){
        throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound("Transaction introuvable");
    }

    $html = view('transactions/pdf', ['transaction' => $transaction]);

    $dompdf = new \Dompdf\Dompdf();
    $dompdf->loadHtml($html);
    $dompdf->setPaper('A4', 'portrait');
    $dompdf->render();
    $dompdf->stream('facture_transaction_'.$id.'.pdf', ['Attachment'=>1]); // force download
}

    // -----------------------------
    // Liste des transactions
    // -----------------------------
   public function index()
{
    $perPage = 20;

    // 🔹 Récupérer utilisateur connecté
    $user = session('user');
    $agenceIdSession = $user['agence_id'] ?? null;

    $builder = $this->transactionModel
        ->select('transactions.*, users.username AS agent, agences.nom AS agence, 
                  operateurs.nom AS operateur, operateur_numeros.numero AS operateur_numero, 
                  clients.nom AS client_nom, clients.telephone AS client_telephone')
        ->join('users', 'users.id = transactions.user_id', 'left')
        ->join('agences', 'agences.id = transactions.agence_id', 'left')
        ->join('operateur_numeros', 'operateur_numeros.id = transactions.operateur_numero_id', 'left')
        ->join('operateurs', 'operateurs.id = operateur_numeros.operateur_id', 'left')
        ->join('clients', 'clients.id = transactions.client_id', 'left');

    // 🔴 FILTRE OBLIGATOIRE PAR AGENCE CONNECTÉE
    if ($agenceIdSession) {
        $builder->where('transactions.agence_id', $agenceIdSession);
    }

    // -------------------------
    // Filtres GET
    // -------------------------
    $agence_id = $this->request->getGet('agence_id');
    $operateur_id = $this->request->getGet('operateur_id');
    $type_transaction = $this->request->getGet('type_transaction');
    $date_start = $this->request->getGet('date_start');
    $date_end = $this->request->getGet('date_end');

    // ⚠️ Empêcher de voir une autre agence
    if ($agence_id && $agence_id == $agenceIdSession) {
        $builder->where('transactions.agence_id', $agence_id);
    }

    if ($operateur_id) {
        $builder->where('operateur_numeros.operateur_id', $operateur_id);
    }

    if ($type_transaction) {
        $builder->where('transactions.type_transaction', $type_transaction);
    }

    if ($date_start) {
        $builder->where('DATE(transactions.created_at) >=', $date_start);
    }

    if ($date_end) {
        $builder->where('DATE(transactions.created_at) <=', $date_end);
    }

    $data['transactions'] = $builder
        ->orderBy('transactions.created_at', 'DESC')
        ->paginate($perPage);

    $data['pager'] = $this->transactionModel->pager;

    // 🔹 IMPORTANT : on ne donne PAS toutes les agences
    $data['agences'] = $this->agenceModel
        ->where('id', $agenceIdSession)
        ->findAll();

    $data['operateurs'] = $this->operateurModel->findAll();

    return view('transactions/index', $data);
}

    // -----------------------------
    // Formulaire création
    // -----------------------------
    public function create()
    {
        $data['agences'] = $this->agenceModel->findAll();
        $data['operateur_numeros'] = $this->operateurNumeroModel
            ->select('operateur_numeros.*, operateurs.nom as operateur_nom')
            ->join('operateurs', 'operateurs.id = operateur_numeros.operateur_id')
            ->findAll();
        $data['clients'] = $this->clientModel->findAll();

        return view('transactions/create', $data);
    }

    // -----------------------------
    // Enregistrement transaction
    // -----------------------------
    public function store()
    {
        $type_transaction = $this->request->getPost('type_transaction');
        $operateur_numero_id = $this->request->getPost('operateur_numero_id');
        $montant = $this->request->getPost('montant');
        $commission = $this->request->getPost('commission') ?? 0;

        // Vérifier client existant ou créer
        $clientNom = $this->request->getPost('client_nom');
        $clientTel = $this->request->getPost('client_telephone');
        $client = $this->clientModel->where('telephone', $clientTel)->first();
        if (!$client) {
            $this->clientModel->insert([
                'nom' => $clientNom,
                'telephone' => $clientTel
            ]);
            $client = $this->clientModel->where('telephone', $clientTel)->first();
        }

        $this->transactionModel->insert([
            'user_id' => 10,
            'client_id' => $client['id'],
            'agence_id' => $this->request->getPost('agence_id'),
            'operateur_numero_id' => $operateur_numero_id,
            'type_transaction' => $type_transaction,
            'montant' => $montant,
            'commission' => $commission,
            'reference_operateur' => $this->request->getPost('reference_operateur')
        ]);

        return redirect()->to('/transactions')->with('success', 'Transaction enregistrée avec succès.');
    }

    // -----------------------------
    // Export Excel
    // -----------------------------
    public function exportExcel()
    {
        $transactions = $this->transactionModel
            ->select('transactions.*, users.username AS agent, agences.nom AS agence, 
                      operateurs.nom AS operateur, operateur_numeros.numero AS operateur_numero, 
                      clients.nom AS client_nom, clients.telephone AS client_telephone')
            ->join('users', 'users.id = transactions.user_id', 'left')
            ->join('agences', 'agences.id = transactions.agence_id', 'left')
            ->join('operateur_numeros', 'operateur_numeros.id = transactions.operateur_numero_id', 'left')
            ->join('operateurs', 'operateurs.id = operateur_numeros.operateur_id', 'left')
            ->join('clients', 'clients.id = transactions.client_id', 'left')
            ->orderBy('transactions.created_at', 'DESC')
            ->findAll();

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        $sheet->fromArray(['ID','Date','Agent','Agence','Opérateur - Numéro','Client','Type','Montant','Commission','Référence'], null, 'A1');

        $row = 2;
        foreach($transactions as $t){
            $sheet->fromArray([
                $t['id'],
                $t['created_at'],
                $t['agent'],
                $t['agence'],
                $t['operateur'].' - '.$t['operateur_numero'],
                $t['client_nom'].' ('.$t['client_telephone'].')',
                $t['type_transaction'],
                $t['montant'],
                $t['commission'],
                $t['reference_operateur']
            ], null, 'A'.$row);
            $row++;
        }

        $writer = new Xlsx($spreadsheet);
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment; filename="transactions.xlsx"');
        $writer->save("php://output");
        exit;
    }

    // -----------------------------
    // Export CSV
    // -----------------------------
    public function exportCSV()
    {
        $transactions = $this->transactionModel->findAll();

        header('Content-Type: text/csv; charset=utf-8');
        header('Content-Disposition: attachment; filename=transactions.csv');

        $output = fopen('php://output', 'w');
        fputcsv($output, ['ID','Date','Agent','Agence','Opérateur - Numéro','Client','Type','Montant','Commission','Référence']);

        foreach($transactions as $t){
            fputcsv($output, [
                $t['id'],
                $t['created_at'],
                $t['user_id'], 
                $t['agence_id'],
                $t['operateur_numero_id'],
                $t['client_id'],
                $t['type_transaction'],
                $t['montant'],
                $t['commission'],
                $t['reference_operateur']
            ]);
        }
        fclose($output);
        exit;
    }

    // -----------------------------
    // Export PDF
    // -----------------------------
    public function exportPDF()
    {
        $transactions = $this->transactionModel->findAll();

        $html = view('transactions/pdf', ['transactions'=>$transactions]);

        $dompdf = new Dompdf();
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'landscape');
        $dompdf->render();
        $dompdf->stream('transactions.pdf', ['Attachment'=>0]);
    }
}