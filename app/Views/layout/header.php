<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mobile Money App - Dashboard</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    <style>
        :root {
            --mm-blue: #0d6efd;
            --mm-dark: #1e293b;
        }

        body {
            padding-top: 75px;
        }

        .navbar {
            background-color: var(--mm-dark) !important;
            padding: 0.8rem 1rem;
            z-index: 1030;
        }

        .navbar-brand {
            font-size: 1.25rem;
            letter-spacing: -0.5px;
        }

        .nav-link {
            font-weight: 500;
            color: rgba(255,255,255,0.85) !important;
            transition: 0.2s;
            margin: 0 5px;
        }

        .nav-link:hover {
            color: #fff !important;
            background: rgba(255,255,255,0.1);
            border-radius: 8px;
        }

        .user-profile-section {
            background: rgba(255,255,255,0.05);
            padding: 6px 15px;
            border-radius: 50px;
            border: 1px solid rgba(255,255,255,0.1);
        }

        .role-badge {
            font-size: 0.65rem;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            padding: 3px 8px;
            background-color: var(--mm-blue);
            color: white;
            border-radius: 4px;
            font-weight: bold;
        }

        .agence-text {
            font-size: 0.7rem;
            color: #38bdf8;
        }

        .dropdown-menu {
            border: none;
            box-shadow: 0 10px 30px rgba(0,0,0,0.15);
            border-radius: 12px;
        }

        .dropdown-item {
            padding: 10px 20px;
            font-size: 0.9rem;
        }

        .dropdown-item i {
            width: 20px;
            color: var(--mm-blue);
        }
    </style>
</head>

<body>

<?php 
$user = session('user');

$username = $user['username'] ?? 'Utilisateur';
$userId   = $user['id'] ?? '0';
$role     = $user['role'] ?? 'Agent';
$agence   = $user['agence_nom'] ?? 'Agence inconnue';

?>

<nav class="navbar navbar-expand-lg navbar-dark shadow-sm fixed-top">
    <div class="container-fluid">

        <!-- LOGO -->
        <a href="/dashboard" class="navbar-brand fw-bold d-flex align-items-center">
            <div class="bg-primary p-2 rounded-3 me-2 d-flex align-items-center justify-content-center" style="width: 35px; height: 35px;">
                <i class="bi bi-wallet2 text-white"></i>
            </div>
            <span>Jhni-Apps</span>
        </a>

        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarMenu">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarMenu">

            <!-- MENU -->
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">

                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" data-bs-toggle="dropdown">
                        <i class="bi bi-arrow-left-right me-1"></i> Transactions
                    </a>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="/transactions"><i class="bi bi-list-ul"></i> Historique</a></li>
                        <li><a class="dropdown-item" href="/transactions/create"><i class="bi bi-plus-circle"></i> Nouvelle</a></li>
                    </ul>
                </li>

                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" data-bs-toggle="dropdown">
                        <i class="bi bi-shop me-1"></i> Réseau
                    </a>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="/agences"><i class="bi bi-building"></i> Agences</a></li>
                        <li><a class="dropdown-item" href="/agence-operateurs"><i class="bi bi-person-gear"></i> Agence-Opérateurs</a></li>
                    </ul>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="/operateurs">
                        <i class="bi bi-hash me-1"></i> Opérateurs
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="/users">
                        <i class="bi bi-people me-1"></i> Utilisateurs
                    </a>
                </li>

            </ul>

            <!-- USER -->
            <div class="dropdown">
                <a href="#" 
                   class="d-flex align-items-center text-decoration-none dropdown-toggle" 
                   id="userDropdown" 
                   data-bs-toggle="dropdown">

                    <div class="user-profile-section d-flex align-items-center me-2">

                        <div class="me-2 text-end d-none d-sm-block">

                            <!-- USER -->
                            <div class="text-white small fw-bold">
                                <?= esc($username) ?>
                            </div>

                           

                        </div>

                        <i class="bi bi-person-circle text-info fs-4"></i>
                    </div>
                </a>

                <!-- DROPDOWN -->
                <ul class="dropdown-menu dropdown-menu-end">

                    <li class="px-3 py-2 d-sm-none">
                        <div class="fw-bold"><?= esc($username) ?></div>
                        <small><?= esc($agence) ?></small><br>
                        <small>ID: <?= esc($userId) ?></small>
                    </li>

                    <li><hr class="dropdown-divider d-sm-none"></li>

                    <li>
                        <a class="dropdown-item" href="/profile">
                            <i class="bi bi-person"></i> Mon Profil
                        </a>
                    </li>

                    <li>
                        <a class="dropdown-item" href="/settings">
                            <i class="bi bi-gear"></i> Paramètres
                        </a>
                    </li>

                    <li><hr class="dropdown-divider"></li>

                    <li>
                        <a class="dropdown-item text-danger" href="/logout">
                            <i class="bi bi-box-arrow-right"></i> Déconnexion
                        </a>
                    </li>

                </ul>
            </div>

        </div>
    </div>
</nav>

<div class="container mt-4">