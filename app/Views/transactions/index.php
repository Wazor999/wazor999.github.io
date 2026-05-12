<?= view('layout/header') ?>

<?php
setlocale(LC_TIME, 'fr_FR.UTF-8');
$request = service('request');

// 🔹 Session
$user = session('user');
$isAdmin = ($user['role'] ?? '') === 'admin'; 

$currentSort = $request->getGet('sort');
$currentOrder = $request->getGet('order');
$nextOrder = ($currentOrder === 'asc') ? 'desc' : 'asc';
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
}

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
.badge.bg-warning { background-color: #fff3cd !important; color: #664d03 !important; }

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
   <span>  <i class="bi bi-building text-secondary"></i> Liste des Transactions</span> 

</div>
<hr>


<div class="mb-3 d-flex flex-wrap gap-2">
    <a href="<?= base_url('transactions/create') ?>" class="btn btn-primary"><i class="bi bi-plus-circle"></i> Nouvelle transaction</a>
    <a href="<?= base_url('transactions/exportExcel') ?>" class="btn btn-success"><i class="bi bi-file-earmark-excel"></i> Excel</a>
    <a href="<?= base_url('transactions/exportCSV') ?>" class="btn btn-info text-white"><i class="bi bi-filetype-csv"></i> CSV</a>
    <a href="<?= base_url('transactions/exportPDF') ?>" class="btn btn-danger"><i class="bi bi-file-earmark-pdf"></i> PDF</a>
</div>

<form method="get" class="row g-3 mb-4">
    <div class="col-md-2 col-6">
        <input type="date" name="date_start" class="form-control" value="<?= esc($request->getGet('date_start')) ?>">
    </div>
    <div class="col-md-2 col-6">
        <input type="date" name="date_end" class="form-control" value="<?= esc($request->getGet('date_end')) ?>">
    </div>
    <?php if($isAdmin): ?>
    <div class="col-md-2 col-6">
        <select name="agence_id" class="form-select">
            <option value="">Toutes agences</option>
            <?php foreach($agences as $a): ?>
                <option value="<?= $a['id'] ?>" <?= $request->getGet('agence_id')==$a['id']?'selected':'' ?>><?= esc($a['nom']) ?></option>
            <?php endforeach; ?>
        </select>
    </div>
    <?php endif; ?>
    <div class="col-md-2 col-6">
        <select name="operateur_id" class="form-select">
            <option value="">Tous opérateurs</option>
            <?php foreach($operateurs as $o): ?>
                <option value="<?= $o['id'] ?>" <?= $request->getGet('operateur_id')==$o['id']?'selected':'' ?>><?= esc($o['nom']) ?></option>
            <?php endforeach; ?>
        </select>
    </div>
    <div class="col-md-2 col-6">
        <select name="type_transaction" class="form-select">
            <option value="">Tous types</option>
            <option value="depot" <?= $request->getGet('type_transaction')=='depot'?'selected':'' ?>>Dépôt</option>
            <option value="retrait" <?= $request->getGet('type_transaction')=='retrait'?'selected':'' ?>>Retrait</option>
            <option value="transfert" <?= $request->getGet('type_transaction')=='transfert'?'selected':'' ?>>Transfert</option>
        </select>
    </div>
    <div class="col-md-2 col-6">
        <button class="btn btn-primary w-100"><i class="bi bi-search"></i> Filtrer</button>
    </div>
</form>

<div class="custom-table-container">
    <div class="table-responsive">
        <table class="table table-hover align-middle mb-0 table-bordered-full">
            <thead class="table-dark">
                <tr>
                    <th>ID</th>
                    <th>Date</th>
                    <?php if($isAdmin): ?><th>Agence</th><?php endif; ?>
                    <th>Opérateur</th>
                    <th>Type</th>
                    <th>Montant</th>
                    <th>Commission</th>
                    <th>Référence</th>
                    <th class="text-center">Action</th>
                </tr>
            </thead>
            <tbody>
                <?php 
                $i=1; 
                $totalMontant = 0; 
                $totalCommission = 0;
                ?>
                <?php if(!empty($transactions)): ?>
                    <?php foreach($transactions as $t): 
                        $totalMontant += $t['montant'];
                        $totalCommission += $t['commission'];
                    ?>
                        <tr>
                            <td><?= $i++ ?></td>
                            <td><?= (new DateTime($t['created_at']))->format('d/m/Y') ?></td>
                            <?php if($isAdmin): ?><td><?= esc($t['agence']) ?></td><?php endif; ?>
                            <td><?= esc($t['operateur']) ?></td>
                            <td>
                                <span class="badge <?= $t['type_transaction']=='depot'?'bg-success':($t['type_transaction']=='retrait'?'bg-danger':'bg-warning text-dark') ?>">
                                    <?= ucfirst($t['type_transaction']) ?>
                                </span>
                            </td>
                            <td><?= number_format($t['montant'],0,',',' ') ?> Ar</td>
                            <td><?= number_format($t['commission'],0,',',' ') ?> Ar</td>
                            <td><code><?= esc($t['reference_operateur']) ?></code></td>
                            <td class="text-center">
                                <div class="btn-group">
                                    <a href="<?= base_url('transactions/print/'.$t['id']) ?>" class="btn btn-sm btn-white border"><i class="bi bi-printer"></i></a>
                                    <a href="<?= base_url('transactions/download/'.$t['id']) ?>" class="btn btn-sm btn-blue border"><i class="bi bi-download"></i></a>
                                </div>
                                <!-- Dropdown mobile -->
                                <div class="d-md-none mt-1">
                                    <button class="btn btn-sm btn-outline-primary dropdown-toggle" type="button" data-bs-toggle="dropdown">Détails</button>
                                    <ul class="dropdown-menu p-2">
                                        <?php if($isAdmin): ?><li>Agence: <?= esc($t['agence']) ?></li><?php endif; ?>
                                        <li>Montant: <?= number_format($t['montant'],0,',',' ') ?> Ar</li>
                                        <li>Numéro: <?= esc($t['operateur_numero']) ?></li>
                                        <li>Client: <?= esc($t['client_nom']) ?> - <?= esc($t['client_telephone']) ?></li>
                                    </ul>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; ?>

                    <!-- Ligne Total -->
                    <tr class="table-light fw-bold">
                        <td colspan="<?= $isAdmin ? '5' : '4' ?>" class="text-end text-uppercase small text-muted">Total</td>
                        <td class="text-primary text-end"><?= number_format($totalMontant,0,',',' ') ?> Ar</td>
                        <td class="text-muted text-end"><?= number_format($totalCommission,0,',',' ') ?> Ar</td>
                        <td colspan="2"></td>
                    </tr>

                <?php else: ?>
                    <tr>
                        <td colspan="9" class="text-center py-5 text-muted">Aucune transaction enregistrée</td>
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