<?php

namespace App\Controllers;

use App\Models\UserModel;
use CodeIgniter\Controller;

class Auth extends Controller
{
    public function login()
    {
        // 🔹 Si l'utilisateur est déjà connecté, redirection vers dashboard
        if (session()->has('user')) {
            return redirect()->to('/dashboard');
        }

        return view('auth/login');
    }

    public function attemptLogin()
    {
        $session = session();
        $request = $this->request;

        // Récupération sécurisée des données
        $email = $request->getPost('email', FILTER_SANITIZE_EMAIL);
        $password = $request->getPost('password');

        if (empty($email) || empty($password)) {
            return redirect()->back()->with('error', 'Veuillez remplir tous les champs');
        }

        $model = new UserModel();
        $user = $model->where('email', $email)->first();

        if ($user && password_verify($password, $user['password'])) {
            // 🔹 Mettre uniquement les infos nécessaires dans la session
            $session->set('user', [
                'id'        => $user['id'],
                'username'  => $user['username'],
                'email'     => $user['email'],
                'agence_id' => $user['agence_id'] ?? null, // si colonne agence_id existe
                'role'      => $user['role'] ?? 'user',    // optionnel
            ]);

            return redirect()->to('/dashboard');
        }

        // 🔹 Login échoué
        return redirect()->back()->with('error', 'Email ou mot de passe invalide');
    }

    public function logout()
    {
        session()->destroy(); // Détruit toutes les sessions
        return redirect()->to('/'); // Redirection vers login
    }
}