<?php

namespace App\Controllers;

use App\Models\TransactionModel;
use App\Models\AgencesModel;
use Dompdf\Dompdf;

class Dashboard extends SecureBaseController
{
    protected $transactionModel;
    protected $agenceModel;

    public function __construct()
    {
        parent::__construct();
        $this->transactionModel = new TransactionModel();
        $this->agenceModel = new AgencesModel();
    }

    /**
     * Page d'accueil du dashboard
     */
    public function index()
    {
        $today = date('Y-m-d');
        $user = session('user');
        $userId = $user['id'] ?? null;
        $agenceId = $user['agence_id'] ?? null;

        // ===================== VOLUME =====================
        $volumeQuery = $this->transactionModel->selectSum('montant')->where('DATE(created_at)', $today);
        if ($agenceId) $volumeQuery->where('agence_id', $agenceId);
        $volumeData = $volumeQuery->first();
        $volume = $volumeData['montant'] ?? 0;

        // ===================== NOMBRE DE TRANSACTIONS =====================
        $nbTransactionsQuery = $this->transactionModel->where('DATE(created_at)', $today);
        if ($agenceId) $nbTransactionsQuery->where('agence_id', $agenceId);
        $nbTransactions = $nbTransactionsQuery->countAllResults();

        // ===================== COMMISSION =====================
        $commissionQuery = $this->transactionModel->selectSum('commission')->where('DATE(created_at)', $today);
        if ($agenceId) $commissionQuery->where('agence_id', $agenceId);
        $commissionData = $commissionQuery->first();
        $totalCommission = $commissionData['commission'] ?? 0;

        // ===================== DERNIERES TRANSACTIONS =====================
        $lastTransactionsQuery = $this->transactionModel
            ->select('transactions.*, users.username AS agent, agences.nom AS agence, 
                      operateurs.nom AS operateur, operateur_numeros.numero AS operateur_numero, 
                      clients.nom AS client_nom, clients.telephone AS client_telephone')
            ->join('users', 'users.id = transactions.user_id', 'left')
            ->join('agences', 'agences.id = transactions.agence_id', 'left')
            ->join('operateur_numeros', 'operateur_numeros.id = transactions.operateur_numero_id', 'left')
            ->join('operateurs', 'operateurs.id = operateur_numeros.operateur_id', 'left')
            ->join('clients', 'clients.id = transactions.client_id', 'left')
            ->orderBy('transactions.created_at', 'DESC')
            ->limit(5);

        if ($agenceId) $lastTransactionsQuery->where('transactions.agence_id', $agenceId);
        $lastTransactions = $lastTransactionsQuery->find();

        // ===================== NOM AGENCE =====================
        $agenceNom = $agenceId ? $this->agenceModel->find($agenceId)['nom'] ?? 'Inconnu' : 'Inconnu';

        // ===================== AGENCES POUR MODALE PDF =====================
        $agences = $this->agenceModel->findAll();

        return view('dashboard/index', [
            'volume' => $volume,
            'nbTransactions' => $nbTransactions,
            'totalCommission' => $totalCommission,
            'lastTransactions' => $lastTransactions,
            'user' => $user,
            'agenceNom' => $agenceNom,
            'agences' => $agences,
        ]);
    }

    /**
     * Export PDF filtré
     */
public function export_pdf()
{
    $request = $this->request;
    $dateStart = $request->getGet('date_start');
    $dateEnd   = $request->getGet('date_end');
    $type      = $request->getGet('type_transaction');
    $clientNum = $request->getGet('client_number');
    $agenceId  = $request->getGet('agence_id');

    // Récupérer le nom de l'agence sélectionnée
    if ($agenceId) {
        $agence = $this->agenceModel->find($agenceId);
        $agenceNom = $agence['nom'] ?? 'Inconnue';
    } else {
        $agenceNom = 'Toutes';
    }

    // Requête transactions
    $query = $this->transactionModel
        ->select('transactions.*, users.username AS agent, agences.nom AS agence, 
                  operateurs.nom AS operateur, operateur_numeros.numero AS operateur_numero, 
                  clients.nom AS client_nom, clients.telephone AS client_telephone')
        ->join('users', 'users.id = transactions.user_id', 'left')
        ->join('agences', 'agences.id = transactions.agence_id', 'left')
        ->join('operateur_numeros', 'operateur_numeros.id = transactions.operateur_numero_id', 'left')
        ->join('operateurs', 'operateurs.id = operateur_numeros.operateur_id', 'left')
        ->join('clients', 'clients.id = transactions.client_id', 'left')
        ->where("DATE(transactions.created_at) >=", $dateStart)
        ->where("DATE(transactions.created_at) <=", $dateEnd)
        ->orderBy('transactions.created_at', 'ASC');

    if ($type) $query->where('transactions.type_transaction', $type);
    if ($clientNum) $query->where('clients.telephone', $clientNum);
    if ($agenceId) $query->where('transactions.agence_id', $agenceId);

    $transactions = $query->findAll();

    // Générer résumé global
    $resume = [];
    foreach ($transactions as $t) {
        $typeTx = $t['type_transaction'];
        if (!isset($resume[$typeTx])) {
            $resume[$typeTx] = [
                'nombre' => 0,
                'montant_total' => 0,
                'commission_total' => 0,
            ];
        }
        $resume[$typeTx]['nombre']++;
        $resume[$typeTx]['montant_total'] += $t['montant'];
        $resume[$typeTx]['commission_total'] += $t['commission'];
    }

    // Générer HTML pour PDF
    $html = view('dashboard/pdf_report', [
        'transactions' => $transactions,
        'resume' => $resume,
        'agenceNom' => $agenceNom,
        'dateStart' => $dateStart,
        'dateEnd' => $dateEnd
    ]);

    // Dompdf
    $dompdf = new \Dompdf\Dompdf();
    $dompdf->loadHtml($html);
    $dompdf->setPaper('A4', 'portrait');
    $dompdf->render();
    $dompdf->stream("rapport_transactions_{$dateStart}_{$dateEnd}.pdf", ["Attachment" => true]);
}
}