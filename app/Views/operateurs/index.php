<?= view('layout/header') ?>

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
    background-color: #dc3545 !important; 
}
.table thead th {
    color: white !important;
    font-weight: 600;
    text-transform: uppercase;
    font-size: 0.75rem;
    letter-spacing: 0.5px;
    border-color: rgba(255,255,255,0.2) !important;
    vertical-align: middle;
}

.table-hover tbody tr:hover {
    background-color: #f1f7ff !important;
    transition: 0.2s;
}

.btn-white {
    background-color: #fff;
    color: #6c757d;
}
.btn-white:hover {
    background-color: #f8f9fa;
}

.badge {
    font-weight: 500;
    padding: 4px 8px;
    border-radius: 6px;
}

@media (max-width: 768px) {
    .table thead th, .table tbody td { font-size: 0.65rem; padding: 6px 8px; }
    .btn-group .btn-sm { padding: 0.25rem 0.4rem; font-size: 0.65rem; }
    .desktop-col { display: none; }
    .dropdown-menu li { color: red; padding: 2px 0; }
}
</style>

<h3 class="mb-3 d-flex align-items-center gap-2">
    <i class="bi bi-telephone-outbound text-secondary"></i>
    <span>Liste des Numéros d'Opérateurs</span>
</h3>


<div class="mb-3">
    <a href="/operateurs/create" class="btn btn-primary">
        <i class="bi bi-plus-circle"></i> Ajouter Numéro
    </a>
</div>

<div class="custom-table-container">
    <div class="table-responsive">
        <table class="table table-hover align-middle mb-0 table-bordered-full">
            <thead class="table-dark">
                <tr>
                    <th class="text-center" style="width: 80px;">ID</th>
                    <th>Numéro</th>
                    <th>Opérateur</th>
                    <th>Description</th>
                    <th class="text-center" style="width: 120px;">Action</th>
                </tr>
            </thead>
            <tbody>
                <?php if(!empty($numeros)): ?>
                    <?php foreach($numeros as $n): ?>
                        <tr>
                            <td class="text-muted fw-bold text-center"><?= $n['id'] ?></td>
                            <td><span class="fw-bold text-dark"><?= esc($n['numero']) ?></span></td>
                            <td>
                                <span class="badge bg-light text-dark border">
                                    <?= esc($n['operateur_nom']) ?>
                                </span>
                            </td>
                            <td class="text-muted small"><?= esc($n['description']) ?></td>
                            <td class="text-center">
                                <div class="btn-group shadow-sm">
                                    <a href="/operateurs/edit/<?= $n['id'] ?>" 
                                       class="btn btn-white btn-sm border text-warning" 
                                       title="Modifier">
                                        <i class="bi bi-pencil-square"></i>
                                    </a>
                                    <a href="/operateurs/delete/<?= $n['id'] ?>" 
                                       class="btn btn-white btn-sm border text-danger" 
                                       onclick="return confirm('Supprimer ce numéro ?')" 
                                       title="Supprimer">
                                        <i class="bi bi-trash"></i>
                                    </a>
                                </div>

                                <!-- Dropdown mobile pour détails -->
                                <div class="d-md-none mt-1">
                                    <button class="btn btn-sm btn-outline-primary dropdown-toggle" type="button" data-bs-toggle="dropdown">Détails</button>
                                    <ul class="dropdown-menu p-2">
                                        <li>ID: <?= $n['id'] ?></li>
                                        <li>Numéro: <?= esc($n['numero']) ?></li>
                                        <li>Opérateur: <?= esc($n['operateur_nom']) ?></li>
                                        <li>Description: <?= esc($n['description']) ?></li>
                                    </ul>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="5" class="text-center py-5 text-muted">
                            Aucun numéro enregistré
                        </td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<?= view('layout/footer') ?>