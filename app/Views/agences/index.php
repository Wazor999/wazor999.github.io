<?= view('layout/header') ?>

<?php
$request = service('request');

// 🔹 Logique de Tri
$currentSort = $request->getGet('sort') ?? 'id';
$currentOrder = $request->getGet('order') ?? 'asc';
$nextOrder = ($currentOrder === 'asc') ? 'desc' : 'asc';

// Fonction utilitaire pour générer l'URL de tri
$sortUrl = function($column) use ($request, $nextOrder) {
    $params = $request->getGet();
    $params['sort'] = $column;
    $params['order'] = $nextOrder;
    return base_url('agences?' . http_build_query($params));
};
?>

<style>
    .custom-table-container {
        background: #fff;
        border-radius: 12px;
        overflow: hidden;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.05);
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

    /* 🔴 En-tête de table en ROUGE */
    .table thead.table-dark {
        background-color: #dc3545; 
    }
    .table thead th {
        color: white;
        font-weight: 600;
        text-transform: uppercase;
        font-size: 0.75rem;
        letter-spacing: 0.5px;
        border-color: rgba(255,255,255,0.2) !important;
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
    
    .table-hover tbody tr:hover {
        background-color: #f1f7ff !important;
        transition: 0.2s;
    }
</style>

<h3 class="mb-3 d-flex align-items-center gap-2">
    <i class="bi bi-building text-secondary"></i>
    <span>Liste des Agences</span>
</h3>

<div class="mb-3">
    <a href="<?= base_url('agences/create') ?>" class="btn btn-primary">
        <i class="bi bi-plus-circle"></i> Ajouter Agence
    </a>
</div>

<form method="get" class="row g-3 mb-4">
    <div class="col-md-4">
        <div class="input-group">
            <span class="input-group-text bg-white"><i class="bi bi-search text-muted"></i></span>
            <input type="text" name="search" class="form-control" placeholder="Rechercher nom, adresse..." value="<?= esc($request->getGet('search')) ?>">
        </div>
    </div>
    <div class="col-md-2">
        <button class="btn btn-danger w-100">Filtrer</button>
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
                        <a href="<?= $sortUrl('nom') ?>" class="sort-link">
                            Nom <?php if($currentSort === 'nom'): ?>
                                <i class="bi bi-sort-alpha-<?= $currentOrder === 'asc' ? 'down' : 'up' ?>"></i>
                            <?php else: ?>
                                <i class="bi bi-arrow-down-up small" style="opacity: 0.5;"></i>
                            <?php endif; ?>
                        </a>
                    </th>
                    <th>Adresse</th>
                    <th>Téléphone</th>
                    <th>Description</th>
                    <th class="text-center">Action</th>
                </tr>
            </thead>
            <tbody>
                <?php if(!empty($agences)): ?>
                    <?php foreach($agences as $a): ?>
                        <tr>
                            <td class="text-muted fw-bold text-center"><?= $a['id'] ?></td>
                            <td><span class="fw-bold text-dark"><?= esc($a['nom']) ?></span></td>
                            <td><i class="bi bi-geo-alt small text-muted"></i> <?= esc($a['adresse']) ?></td>
                            <td class="fw-semibold text-primary"><?= esc($a['telephone']) ?></td>
                            <td class="text-muted small"><?= esc($a['description']) ?></td>
                            <td class="text-center">
                                <div class="btn-group shadow-sm">
                                    <a href="<?= base_url('agences/edit/'.$a['id']) ?>" class="btn btn-white btn-sm border text-warning" title="Modifier">
                                        <i class="bi bi-pencil-square"></i>
                                    </a>
                                    <a href="<?= base_url('agences/delete/'.$a['id']) ?>" 
                                       class="btn btn-white btn-sm border text-danger"
                                       onclick="return confirm('Supprimer cette agence ?')" title="Supprimer">
                                        <i class="bi bi-trash"></i>
                                    </a>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="6" class="text-center py-5 text-muted">Aucune agence enregistrée</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<?= view('layout/footer') ?>