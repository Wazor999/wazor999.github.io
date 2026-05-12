<?= view('layout/header') ?>

<?php
$request = service('request');
$userSession = session('user');
$isAdmin = ($userSession['role'] ?? '') === 'admin'; 

// 🔹 Logique de Tri
$currentSort = $request->getGet('sort') ?? 'id';
$currentOrder = $request->getGet('order') ?? 'asc';
$nextOrder = ($currentOrder === 'asc') ? 'desc' : 'asc';

// Fonction utilitaire pour générer l'URL de tri
$sortUrl = function($column) use ($request, $nextOrder) {
    $params = $request->getGet();
    $params['sort'] = $column;
    $params['order'] = $nextOrder;
    return base_url('users?' . http_build_query($params));
};
?>

<style>
.custom-table-container {
    background: #fff;
    border-radius: 12px;
    overflow: hidden;
    box-shadow: 0 10px 30px rgba(0,0,0,0.05);
    border: 1px solid #dee2e6;
}

.table-bordered-full {
    border-collapse: collapse !important;
}
.table-bordered-full thead th,
.table-bordered-full tbody td {
    border: 1px solid #dee2e6 !important;
    padding: 12px 15px;
}

.table thead.table-dark {
    background-color: #002349; 
}
.table thead th {
    color: white;
    font-weight: 600;
    text-transform: uppercase;
    font-size: 0.75rem;
    letter-spacing: 0.5px;
    border-color: rgba(255,255,255,0.1) !important;
    vertical-align: middle;
}

.sort-link {
    color: white !important;
    text-decoration: none;
    display: flex;
    align-items: center;
    justify-content: space-between;
    width: 100%;
}
.sort-link:hover { opacity: 0.8; }

.table-hover tbody tr:hover {
    background-color: #f1f7ff !important;
    transition: 0.2s;
}

.badge {
    font-weight: 500;
    padding: 6px 12px;
    border-radius: 6px;
}
.badge.bg-success { background-color: #d1e7dd !important; color: #0f5132 !important; }
.badge.bg-danger { background-color: #f8d7da !important; color: #842029 !important; }
.badge.bg-info { background-color: #cff4fc !important; color: #055160 !important; }
.badge.bg-secondary { background-color: #e2e3e5 !important; color: #41464b !important; }

@media (max-width: 768px) {
    .table thead th, .table tbody td { font-size: 0.65rem; padding: 6px 8px; }
    .btn-group .btn-sm { padding: 0.25rem 0.4rem; font-size: 0.65rem; }
    .desktop-col { display: none; }
    .dropdown-menu li { color: red; padding: 2px 0; }
}

.welcome-text {
    background: linear-gradient(90deg,#002349,#0056b3);
    color: white;
    font-size: 1.1rem;
    font-weight: 600;
    padding: 12px 15px;
    border-radius: 8px;
    margin-bottom: 1rem;
    box-shadow: 0 5px 15px rgba(0,0,0,0.1);
}
</style>

<!-- Texte de bienvenue -->
<div class="welcome-text">
        <i class="bi bi-people-fill text-secondary"></i>
    <span>Liste des Utilisateurs</span>
</div>
<hr>

<div class="mb-3">
    <a href="<?= base_url('users/create') ?>" class="btn btn-primary">
        <i class="bi bi-plus-circle"></i> Créer un utilisateur
    </a>
</div>

<form method="get" class="row g-3 mb-4">
    <div class="col-md-3">
        <input type="text" name="search" class="form-control" placeholder="Rechercher nom ou email..." value="<?= esc($request->getGet('search')) ?>">
    </div>
    <?php if($isAdmin): ?>
    <div class="col-md-3">
        <select name="agence_id" class="form-select">
            <option value="">Toutes les agences</option>
            <?php foreach($agences as $a): ?>
                <option value="<?= $a['id'] ?>" <?= $request->getGet('agence_id') == $a['id'] ? 'selected' : '' ?>>
                    <?= esc($a['nom']) ?>
                </option>
            <?php endforeach; ?>
        </select>
    </div>
    <?php endif; ?>
    <div class="col-md-2">
        <select name="role" class="form-select">
            <option value="">Tous les rôles</option>
            <option value="admin" <?= $request->getGet('role') == 'admin' ? 'selected' : '' ?>>Admin</option>
            <option value="caissier" <?= $request->getGet('role') == 'caissier' ? 'selected' : '' ?>>Caissier</option>
            <option value="agent" <?= $request->getGet('role') == 'agent' ? 'selected' : '' ?>>Agent</option>
        </select>
    </div>
    <div class="col-md-2">
        <button class="btn btn-danger w-100">
            <i class="bi bi-search"></i> Filtrer
        </button>
    </div>
</form>

<div class="custom-table-container">
    <div class="table-responsive">
        <table class="table table-hover align-middle mb-0 table-bordered-full">
            <thead class="table-dark">
                <tr>
                    <th class="text-center" style="width: 70px;">
                        <a href="<?= $sortUrl('id') ?>" class="sort-link">
                            ID <?php if($currentSort === 'id'): ?>
                                <i class="bi bi-sort-numeric-<?= $currentOrder === 'asc' ? 'down' : 'up' ?>"></i>
                            <?php else: ?>
                                <i class="bi bi-arrow-down-up small" style="opacity: 0.5;"></i>
                            <?php endif; ?>
                        </a>
                    </th>
                    <th>
                        <a href="<?= $sortUrl('username') ?>" class="sort-link">
                            Utilisateur <?php if($currentSort === 'username'): ?>
                                <i class="bi bi-sort-alpha-<?= $currentOrder === 'asc' ? 'down' : 'up' ?>"></i>
                            <?php else: ?>
                                <i class="bi bi-arrow-down-up small" style="opacity: 0.5;"></i>
                            <?php endif; ?>
                        </a>
                    </th>
                    <th>Email</th>
                    <th>Agence</th>
                    <th>Rôles</th>
                    <th class="text-center">Action</th>
                </tr>
            </thead>
            <tbody>
                <?php if(!empty($users)): ?>
                    <?php foreach($users as $u): ?>
                        <tr>
                            <td class="text-muted fw-bold text-center"><?= $u['id'] ?></td>
                            <td><span class="fw-bold text-dark"><?= esc($u['username']) ?></span></td>
                            <td><?= esc($u['email']) ?></td>
                            <td>
                                <?= !empty($u['agence_nom']) ? '<span class="fw-semibold">' . esc($u['agence_nom']) . '</span>' : '<span class="text-muted small">Aucune</span>' ?>
                            </td>
                            <td>
                                <?php if(!empty($u['roles'])): ?>
                                    <?php foreach(explode(',', $u['roles']) as $role): ?>
                                        <span class="badge bg-info me-1"><?= trim($role) ?></span>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <span class="badge bg-secondary">Aucun rôle</span>
                                <?php endif; ?>
                            </td>
                            <td class="text-center">
                                <div class="btn-group shadow-sm">
                                    <a href="<?= base_url('users/edit/'.$u['id']) ?>" class="btn btn-warning btn-sm border text-white" title="Modifier">
                                        <i class="bi bi-pencil-square"></i>
                                    </a>
                                    <a href="<?= base_url('users/delete/'.$u['id']) ?>" 
                                       class="btn btn-white btn-danger btn-sm border text-white"
                                       onclick="return confirm('Supprimer cet utilisateur ?')" title="Supprimer">
                                        <i class="bi bi-trash"></i>
                                    </a>
                                </div>
                                <!-- Dropdown mobile -->
                                <div class="d-md-none mt-1">
                                    <button class="btn btn-sm btn-outline-primary dropdown-toggle" type="button" data-bs-toggle="dropdown">Détails</button>
                                    <ul class="dropdown-menu p-2">
                                        <li>Nom: <?= esc($u['username']) ?></li>
                                        <li>Email: <?= esc($u['email']) ?></li>
                                        <li>Agence: <?= !empty($u['agence_nom']) ? esc($u['agence_nom']) : 'Aucune' ?></li>
                                        <li>Rôles: <?= !empty($u['roles']) ? esc($u['roles']) : 'Aucun' ?></li>
                                        <li>Actif: <?= $u['is_active']==1 ? 'Oui' : 'Non' ?></li>
                                    </ul>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="6" class="text-center py-5 text-muted">Aucun utilisateur trouvé</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<div class="mt-4 d-flex justify-content-center">
    <?= $pager->links('default', 'bootstrap') ?>
</div>

<?= view('layout/footer') ?>