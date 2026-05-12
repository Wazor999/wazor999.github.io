<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

// Authentification
$routes->get('/', 'Auth::login');
$routes->post('/login', 'Auth::attemptLogin');
$routes->get('/logout', 'Auth::logout');

// Dashboard
$routes->get('/dashboard', 'Dashboard::index');

// Utilisateurs
$routes->get('/users', 'User::index');
$routes->get('/users/create', 'User::create');
$routes->post('/users/store', 'User::store');
$routes->get('/users/edit/(:num)', 'User::edit/$1');
$routes->post('/users/update/(:num)', 'User::update/$1');
$routes->get('/users/delete/(:num)', 'User::delete/$1');

// Transactions
//$routes->get('/transactions', 'Transactions::index');
//$routes->get('/transactions/create', 'Transactions::create');
//$routes->post('/transactions/store', 'Transactions::store');

// Agence / Opérateur / Fonds
$routes->get('/agence-operateurs', 'AgenceOperateurs::index');
$routes->get('/agence-operateurs/create', 'AgenceOperateurs::create');
$routes->post('/agence-operateurs/store', 'AgenceOperateurs::store');
$routes->get('/agence-operateurs/edit/(:num)', 'AgenceOperateurs::edit/$1');
$routes->post('/agence-operateurs/update/(:num)', 'AgenceOperateurs::update/$1');
$routes->get('/agence-operateurs/delete/(:num)', 'AgenceOperateurs::delete/$1');

// Clients
$routes->get('clients/search/(:any)', 'ClientsController::search/$1');
$routes->post('clients/storeAjax', 'Clients::storeAjax');

// --------------------------------------------------
// Module Operateurs & Numéros
// --------------------------------------------------
$routes->group('operateurs', function($routes){

    // Liste des numéros
    $routes->get('/', 'OperateursController::index');

    // Ajouter un numéro
    $routes->get('create', 'OperateursController::create');
    $routes->post('store', 'OperateursController::store');

    // Modifier un numéro
    $routes->get('edit/(:num)', 'OperateursController::edit/$1');
    $routes->post('update/(:num)', 'OperateursController::update/$1');

    // Supprimer un numéro
    $routes->get('delete/(:num)', 'OperateursController::delete/$1');
});

// Agences
$routes->get('/agences', 'AgencesController::index');
$routes->get('/agences/create', 'AgencesController::create');
$routes->post('/agences/store', 'AgencesController::store');
$routes->get('/agences/edit/(:num)', 'AgencesController::edit/$1');
$routes->post('/agences/update/(:num)', 'AgencesController::update/$1');
$routes->get('/agences/delete/(:num)', 'AgencesController::delete/$1');
$routes->get('transactions/print/(:num)', 'Transactions::print/$1');
// Route pour télécharger le ticket PDF d'une transaction
$routes->get('transactions/download/(:num)', 'Transactions::download/$1');
$routes->get('dashboard/reports', 'Dashboard::reports');
$routes->get('dashboard/export_pdf', 'Dashboard::export_pdf');

// Transactions
$routes->get('/transactions', 'Transactions::index');               // Liste + filtres
$routes->get('/transactions/create', 'Transactions::create');       // Formulaire création
$routes->post('/transactions/store', 'Transactions::store');        // Enregistrement

// Exports
$routes->get('/transactions/exportExcel', 'Transactions::exportExcel'); // Export Excel
$routes->get('/transactions/exportCSV', 'Transactions::exportCSV');     // Export CSV
$routes->get('/transactions/exportPDF', 'Transactions::exportPDF');     // Export PDF