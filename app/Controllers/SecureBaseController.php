<?php

namespace App\Controllers;

use CodeIgniter\Controller;

class SecureBaseController extends Controller
{
    protected $user; // Stocke les informations utilisateur de la session

    public function __construct()
    {
        helper('url'); // Pour utiliser base_url()

        $session = session();

        // 🔹 Vérifie si l'utilisateur est connecté
        $this->user = $session->get('user');

        if (!$this->user) {
            // Redirection vers la page de login
            redirect()->to(base_url('/'))->send();
            exit;
        }
    }

    /**
     * Récupère les informations de l'utilisateur courant
     */
    protected function getUser()
    {
        return $this->user;
    }

    /**
     * Récupère l'ID de l'agence de l'utilisateur courant
     */
    protected function getAgenceId()
    {
        return $this->user['agence_id'] ?? null;
    }

    /**
     * Récupère l'ID de l'utilisateur
     */
    protected function getUserId()
    {
        return $this->user['id'] ?? null;
    }

    /**
     * Récupère le nom de l'utilisateur
     */
    protected function getUsername()
    {
        return $this->user['username'] ?? 'Utilisateur';
    }
}