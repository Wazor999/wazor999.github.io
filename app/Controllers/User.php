<?php
namespace App\Controllers;

use App\Models\UserModel;
use App\Models\RoleModel;
use App\Models\AgencesModel;

class User extends SecureBaseController
{
    /**
     * Liste des utilisateurs
     */
    public function __construct()
    {
         parent::__construct(); // 🔹 Vérifie la session utilisateur
    }
    public function index()
        {
            $userModel = new UserModel();

            // Récupère les utilisateurs paginés avec agence et rôles
            $data['users'] = $userModel->getUsersWithRoles(10); // 10 par page
            $data['pager'] = $userModel->pager;

            return view('users/index', $data);
        }

    /**
     * Affiche le formulaire de création
     */
    public function create()
    {
        $roleModel = new RoleModel();
        $agenceModel = new AgencesModel();

        $data['roles'] = $roleModel->findAll();
        $data['agences'] = $agenceModel->findAll();

        return view('users/create', $data);
    }

    /**
     * Stocke un nouvel utilisateur
     */
   public function store()
{
    $userModel = new UserModel();
    $db = \Config\Database::connect();

    $passwordInput = $this->request->getPost('password');

    // 🔴 Vérification sécurité
    if(empty($passwordInput)){
        return redirect()->back()->with('error', 'Mot de passe obligatoire');
    }

    $password = password_hash($passwordInput, PASSWORD_DEFAULT);

    $userModel->insert([
        'username'   => $this->request->getPost('username'),
        'email'      => $this->request->getPost('email'),
        'password'   => $password, // ✅ OK
        'agence_id'  => $this->request->getPost('agence_id'),
        'phone'      => $this->request->getPost('phone'),
        'is_active'  => $this->request->getPost('is_active') ? 1 : 0
    ]);

    $userId = $userModel->getInsertID();

    // 🔹 Rôles
    $roles = $this->request->getPost('roles');
    if($roles){
        foreach($roles as $roleId){
            $db->table('user_roles')->insert([
                'user_id' => $userId,
                'role_id' => $roleId
            ]);
        }
    }

    return redirect()->to('/users')->with('success','Utilisateur créé avec succès');
}

    /**
     * Affiche le formulaire d'édition
     */
    public function edit($id)
    {
        $userModel = new UserModel();
        $roleModel = new RoleModel();
        $agenceModel = new AgencesModel();
        $db = \Config\Database::connect();

        $data['user'] = $userModel->find($id);
        $data['roles'] = $roleModel->findAll();
        $data['agences'] = $agenceModel->findAll();

        $userRoles = $db->table('user_roles')
                        ->where('user_id', $id)
                        ->get()
                        ->getResultArray();
        $data['userRoleIds'] = array_column($userRoles,'role_id');

        return view('users/edit', $data);
    }

    /**
     * Met à jour l'utilisateur
     */
   public function update($id)
{
    $userModel = new UserModel();
    $db = \Config\Database::connect();

    $data = [
        'username'   => $this->request->getPost('username'),
        'email'      => $this->request->getPost('email'),
        'agence_id'  => $this->request->getPost('agence_id'),
        'phone'      => $this->request->getPost('phone'),
        'is_active'  => $this->request->getPost('is_active') ? 1 : 0
    ];

    // 🔴 Si mot de passe rempli → on update
    if($this->request->getPost('password')){
        $data['password'] = password_hash($this->request->getPost('password'), PASSWORD_DEFAULT);
    }

    $userModel->update($id, $data);

    // 🔹 Reset rôles
    $db->table('user_roles')->where('user_id', $id)->delete();

    $roles = $this->request->getPost('roles');
    if($roles){
        foreach($roles as $roleId){
            $db->table('user_roles')->insert([
                'user_id' => $id,
                'role_id' => $roleId
            ]);
        }
    }

    return redirect()->to('/users')->with('success','Utilisateur mis à jour');
}

    /**
     * Supprime un utilisateur
     */
    public function delete($id)
    {
        $userModel = new UserModel();
        $db = \Config\Database::connect();

        // Supprimer les rôles associés
        $db->table('user_roles')->where('user_id', $id)->delete();

        // Supprimer l'utilisateur
        $userModel->delete($id);

        return redirect()->to('/users');
    }
}