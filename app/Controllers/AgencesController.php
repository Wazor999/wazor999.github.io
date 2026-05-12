<?php
namespace App\Controllers;

use App\Models\AgencesModel;

class AgencesController extends SecureBaseController
{
    protected $agencesModel;

    public function __construct()
    {
        parent::__construct(); // 🔹 Vérifie la session utilisateur

        $this->agencesModel = new AgencesModel();
    }

    // Liste des agences
    public function index()
    {
        $data['agences'] = $this->agencesModel->findAll();
        return view('agences/index', $data);
    }

    // Formulaire création
    public function create()
    {
        return view('agences/create');
    }

    // Enregistrement
    public function store()
    {
        $nom = $this->request->getPost('nom');

        if (!$nom) {
            return redirect()->back()->with('error', 'Le nom de l’agence est requis.');
        }

        $this->agencesModel->insert([
            'nom' => $nom,
            'adresse' => $this->request->getPost('adresse'),
            'telephone' => $this->request->getPost('telephone'),
            'description' => $this->request->getPost('description')
        ]);

        return redirect()->to('/agences')->with('success', 'Agence ajoutée avec succès.');
    }

    // Formulaire édition
    public function edit($id)
    {
        $data['agence'] = $this->agencesModel->find($id);
        if (!$data['agence']) {
            return redirect()->to('/agences')->with('error', 'Agence introuvable.');
        }

        return view('agences/edit', $data);
    }

    // Mise à jour
    public function update($id)
    {
        $agence = $this->agencesModel->find($id);
        if (!$agence) {
            return redirect()->to('/agences')->with('error', 'Agence introuvable.');
        }

        $this->agencesModel->update($id, [
            'nom' => $this->request->getPost('nom'),
            'adresse' => $this->request->getPost('adresse'),
            'telephone' => $this->request->getPost('telephone'),
            'description' => $this->request->getPost('description')
        ]);

        return redirect()->to('/agences')->with('success', 'Agence mise à jour.');
    }

    // Supprimer
    public function delete($id)
    {
        $this->agencesModel->delete($id);
        return redirect()->to('/agences')->with('success', 'Agence supprimée.');
    }
}