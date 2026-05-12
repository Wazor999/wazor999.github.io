<?php
namespace App\Controllers;

use App\Models\AgenceOperateurModel;
use App\Models\AgencesModel;
use App\Models\OperateurNumerosModel;
use App\Models\OperateursModel;

class AgenceOperateurs extends SecureBaseController
{
    protected $agenceOperateurModel;
    protected $agencesModel;
    protected $operateurNumerosModel;
    protected $operateursModel;

    public function __construct()

    {
        parent::__construct(); // 🔹 Vérifie la session utilisateur
        $this->agenceOperateurModel = new AgenceOperateurModel();
        $this->agencesModel = new AgencesModel();
        $this->operateurNumerosModel = new OperateurNumerosModel();
        $this->operateursModel = new OperateursModel();
    }

    // Liste des fonds
    public function index()
    {
        $db = \Config\Database::connect();
        $query = $db->query("
            SELECT ao.*, a.nom AS agence_nom, onum.numero AS numero, o.nom AS operateur_nom
            FROM agence_operateurs ao
            LEFT JOIN agences a ON a.id = ao.agence_id
            LEFT JOIN operateur_numeros onum ON onum.id = ao.operateur_numero_id
            LEFT JOIN operateurs o ON o.id = onum.operateur_id
            ORDER BY ao.agence_id, ao.operateur_numero_id
        ");
        $data['fonds'] = $query->getResultArray();

        return view('agence_operateurs/index', $data);
    }

    // Formulaire création
    public function create()
    {
        $data['agences'] = $this->agencesModel->findAll();
        $data['operateur_numeros'] = $this->operateurNumerosModel
            ->select('operateur_numeros.*, operateurs.nom as operateur_nom')
            ->join('operateurs', 'operateurs.id = operateur_numeros.operateur_id')
            ->findAll();

        return view('agence_operateurs/create', $data);
    }

    // Enregistrement
    public function store()
    {
        $agence_id = $this->request->getPost('agence_id');
        $operateur_numero_id = $this->request->getPost('operateur_numero_id');
        $solde_initial = $this->request->getPost('solde_initial');

        // Vérifier que le numéro d’opérateur existe
        $numero = $this->operateurNumerosModel->find($operateur_numero_id);
        if (!$numero) {
            return redirect()->back()->with('error', 'Numéro d’opérateur invalide.');
        }

        // Vérifier doublon agence + numéro
        $existe = $this->agenceOperateurModel
                        ->where('agence_id', $agence_id)
                        ->where('operateur_numero_id', $operateur_numero_id)
                        ->first();
        if ($existe) {
            return redirect()->back()->with('error', 'Ce numéro est déjà configuré pour cette agence.');
        }

        // Insertion avec récupération de operateur_id depuis le numéro
        $this->agenceOperateurModel->insert([
            'agence_id' => $agence_id,
            'operateur_id' => $numero['operateur_id'],
            'operateur_numero_id' => $operateur_numero_id,
            'solde_initial' => $solde_initial,
            'solde_actuel' => $solde_initial,
            'caisse_reelle' => $solde_initial
        ]);

        return redirect()->to('/agence-operateurs')->with('success', 'Numéro ajouté avec succès.');
    }

    // Formulaire édition
    public function edit($id)
    {
        $fonds = $this->agenceOperateurModel->find($id);
        if (!$fonds) {
            return redirect()->to('/agence-operateurs')->with('error', 'Fonds introuvable.');
        }

        $data['fonds'] = $fonds;
        $data['agences'] = $this->agencesModel->findAll();
        $data['operateur_numeros'] = $this->operateurNumerosModel
            ->select('operateur_numeros.*, operateurs.nom as operateur_nom')
            ->join('operateurs', 'operateurs.id = operateur_numeros.operateur_id')
            ->findAll();

        return view('agence_operateurs/edit', $data);
    }

    // Mise à jour
    public function update($id)
    {
        $fonds = $this->agenceOperateurModel->find($id);
        if (!$fonds) {
            return redirect()->to('/agence-operateurs')->with('error', 'Fonds introuvable.');
        }

        $agence_id = $this->request->getPost('agence_id');
        $operateur_numero_id = $this->request->getPost('operateur_numero_id');

        // Vérifier que le numéro existe
        $numero = $this->operateurNumerosModel->find($operateur_numero_id);
        if (!$numero) {
            return redirect()->back()->with('error', 'Numéro d’opérateur invalide.');
        }

        // Vérifier doublon (exclure l’élément courant)
        $existe = $this->agenceOperateurModel
                        ->where('agence_id', $agence_id)
                        ->where('operateur_numero_id', $operateur_numero_id)
                        ->where('id !=', $id)
                        ->first();
        if ($existe) {
            return redirect()->back()->with('error', 'Ce numéro est déjà configuré pour cette agence.');
        }

        $this->agenceOperateurModel->update($id, [
            'agence_id' => $agence_id,
            'operateur_id' => $numero['operateur_id'],
            'operateur_numero_id' => $operateur_numero_id,
            'solde_initial' => $this->request->getPost('solde_initial'),
            'solde_actuel' => $this->request->getPost('solde_actuel'),
            'caisse_reelle' => $this->request->getPost('caisse_reelle')
        ]);

        return redirect()->to('/agence-operateurs')->with('success', 'Mise à jour effectuée.');
    }

    // Supprimer
    public function delete($id)
    {
        $fonds = $this->agenceOperateurModel->find($id);
        if (!$fonds) {
            return redirect()->to('/agence-operateurs')->with('error', 'Fonds introuvable.');
        }

        $this->agenceOperateurModel->delete($id);
        return redirect()->to('/agence-operateurs')->with('success', 'Fonds supprimé.');
    }
}