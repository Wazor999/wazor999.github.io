<?php
namespace App\Controllers;

use App\Models\OperateursModel;
use App\Models\OperateurNumerosModel;

class OperateursController extends SecureBaseController
{
    protected $operateursModel;
    protected $operateurNumerosModel;

    public function __construct()
    {
        $this->operateursModel = new OperateursModel();
        $this->operateurNumerosModel = new OperateurNumerosModel();
    }

    // Liste des numéros
    public function index()
    {
        $db = \Config\Database::connect();
        $query = $db->query("
            SELECT onum.*, o.nom AS operateur_nom
            FROM operateur_numeros onum
            LEFT JOIN operateurs o ON o.id = onum.operateur_id
            ORDER BY o.nom, onum.numero
        ");
        $data['numeros'] = $query->getResultArray();

        return view('operateurs/index', $data);
    }

    // Formulaire création
    public function create()
    {
        $data['operateurs'] = $this->operateursModel->findAll();
        return view('operateurs/create', $data);
    }

    // Enregistrement
    public function store()
    {
        $operateur_id = $this->request->getPost('operateur_id');
        $numero = $this->request->getPost('numero');
        $description = $this->request->getPost('description');

        $existe = $this->operateurNumerosModel->where('numero',$numero)->first();
        if($existe){
            return redirect()->back()->with('error','Ce numéro existe déjà.');
        }

        $this->operateurNumerosModel->insert([
            'operateur_id' => $operateur_id,
            'numero' => $numero,
            'description' => $description
        ]);

        return redirect()->to('/operateurs')->with('success','Numéro ajouté.');
    }

    // Formulaire édition
    public function edit($id)
    {
        $data['numero'] = $this->operateurNumerosModel->find($id);
        $data['operateurs'] = $this->operateursModel->findAll();
        return view('operateurs/edit', $data);
    }

    // Mise à jour
    public function update($id)
    {
        $this->operateurNumerosModel->update($id, [
            'operateur_id' => $this->request->getPost('operateur_id'),
            'numero' => $this->request->getPost('numero'),
            'description' => $this->request->getPost('description')
        ]);
        return redirect()->to('/operateurs')->with('success','Numéro mis à jour.');
    }

    // Supprimer
    public function delete($id)
    {
        $this->operateurNumerosModel->delete($id);
        return redirect()->to('/operateurs')->with('success','Numéro supprimé.');
    }
}