<?= view('layout/header') ?>

<style>
:root {
    --mm-main-bg: #f4f7fc;
    --mm-card-shadow: 0 10px 40px rgba(29, 52, 115, 0.05);
    --mm-accent-blue: #0d6efd;
    --mm-success: #2ecc71;
    --mm-text-dark: #1e293b;
    --mm-text-muted: #64748b;
}

body { 
    background-color: var(--mm-main-bg) !important; 
    font-family: 'Segoe UI', Roboto, sans-serif; 
}

/* ✨ Texte de bienvenue animé */
@keyframes fadeInUp {
    0% { opacity: 0; transform: translateY(20px); }
    100% { opacity: 1; transform: translateY(0); }
}

/* Cartes de stats */
.stat-card { 
    border: none; 
    border-radius: 20px; 
    background: #fff; 
    box-shadow: var(--mm-card-shadow); 
    transition: 0.3s; 
}
.stat-card:hover { 
    transform: translateY(-5px); 
    box-shadow: 0 15px 50px rgba(29,52,115,0.1); 
}
.icon-box { 
    width: 55px; 
    height: 55px; 
    display: flex; 
    align-items:center; 
    justify-content:center; 
    border-radius:16px; 
    font-size:1.6rem; 
}

/* Tables premium */
.premium-table-card { 
    border: none; 
    border-radius: 20px; 
    box-shadow: var(--mm-card-shadow); 
    overflow: hidden; 
}
.premium-table thead th { 
    background-color: #f8fafc; 
    color: var(--mm-text-muted); 
    text-transform: uppercase; 
    font-size:0.75rem; 
    letter-spacing:0.5px; 
    padding:1.25rem 1.5rem; 
}
.premium-table tbody td { padding:1.25rem 1.5rem; }
.premium-table tbody tr:hover { background-color:#fbfdff; }

/* Actions */
.actions-card { border: none; border-radius: 20px; box-shadow: var(--mm-card-shadow); }
.btn-mm-primary { 
    background: linear-gradient(135deg, var(--mm-accent-blue) 0%, #3498db 100%); 
    color:white; border:none; border-radius:12px; padding:14px; font-weight:600; font-size:.95rem; 
    box-shadow:0 4px 15px rgba(13,110,253,.2); 
}
.btn-mm-primary:hover { 
    background: linear-gradient(135deg, #0b6edb 0%, #2e8bcc 100%); color:white; 
}
.badge-info { background-color: #0d6efd20; color: #0d6efd; font-weight: 500; margin-left: 5px; }
.badge-success { background-color: #2ecc7120; color: #2ecc71; font-weight: 500; margin-left: 5px; }
</style>

<div class="container-fluid py-5">

    <!-- HEADER -->
    <div class="row mb-5 align-items-center">
        <div class="col-8">
            <?php 
                $username = $user['username'] ?? 'Utilisateur'; 
                $userId = $user['id'] ?? ''; 
                $agenceNom = $agenceNom ?? 'Agence inconnue';
            ?>
            <h2 class="fw-bold mb-1" style="
                background: linear-gradient(90deg, #ff7e5f, #feb47b);
                -webkit-background-clip: text;
                -webkit-text-fill-color: transparent;
                font-size: 2.25rem;
                animation: fadeInUp 1s ease;
            ">
                Bienvenue, <?= htmlspecialchars($username) ?> 👋
            </h2>
            <p class="mb-0" style="font-size:1rem; color:#34495e; font-weight:500;">
                Réseau d'agences / 
                <span style="
                    background: linear-gradient(135deg, #6a11cb, #2575fc);
                    -webkit-background-clip: text;
                    -webkit-text-fill-color: transparent;
                    font-weight:700;
                    font-size:1.2rem;
                ">
                    <?= htmlspecialchars($agenceNom) ?>
                </span>
              
            </p>
        </div>
        <div class="col-4 text-end">
            <button class="btn btn-white shadow-sm rounded-pill px-4" data-bs-toggle="modal" data-bs-target="#filterModal">
                <i class="bi bi-filter-circle me-2"></i> Rapport de transaction / Exporter PDF
            </button>
        </div>
    </div>

    <!-- STAT CARDS -->
    <div class="row g-4 mb-5">
        <div class="col-md-4">
            <div class="card stat-card p-3">
                <div class="d-flex align-items-center">
                    <div class="icon-box bg-primary bg-opacity-10 text-primary me-3">
                        <i class="bi bi-wallet2"></i>
                    </div>
                    <div>
                        <small class="text-muted d-block fw-semibold mb-1">Total d'opération effectué (24h)</small>
                        <h3 class="fw-bold text-dark mb-0"><?= number_format($volume,0,',',' ') ?> Ar</h3>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card stat-card p-3">
                <div class="d-flex align-items-center">
                    <div class="icon-box bg-success bg-opacity-10 text-success me-3">
                        <i class="bi bi-arrow-repeat"></i>
                    </div>
                    <div>
                        <small class="text-muted d-block fw-semibold mb-1">Transactions (24h)</small>
                        <h3 class="fw-bold text-dark mb-0"><?= $nbTransactions ?> <span class="fs-6 text-muted">Ops</span></h3>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card stat-card p-3">
                <div class="d-flex align-items-center">
                    <div class="icon-box bg-warning bg-opacity-10 text-warning me-3">
                        <i class="bi bi-cash-stack"></i>
                    </div>
                    <div>
                        <small class="text-muted d-block fw-semibold mb-1">Commission Total (24h)</small>
                        <h3 class="fw-bold text-warning mb-0"><?= number_format($totalCommission,0,',',' ') ?> Ar</h3>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- DERNIERES TRANSACTIONS -->
    <div class="row">
        <div class="col-xl-8 mb-4">
            <div class="card premium-table-card">
                <div class="card-header bg-white border-0 py-4 px-4 d-flex justify-content-between align-items-center">
                    <h5 class="fw-bold mb-0">Dernières Activités JHNi</h5>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table premium-table align-middle mb-0">
                            <thead>
                                <tr>
                                    <th>Type</th>
                                    <th>Détails & Heure</th>
                                    <th>Montant</th>
                                    <th class="text-end">Status</th>
                                </tr>
                            </thead>
                            <tbody>
                            <?php if(!empty($lastTransactions)): ?>
                                <?php foreach($lastTransactions as $t): ?>
                                    <tr>
                                        <td>
                                            <div class="rounded-circle d-flex align-items-center justify-content-center bg-light" style="width:45px;height:45px;">
                                                <i class="bi 
                                                    <?= $t['type_transaction']=='depot'?'bi-plus-lg text-success':'' ?>
                                                    <?= $t['type_transaction']=='retrait'?'bi-dash-lg text-danger':'' ?>
                                                    <?= $t['type_transaction']=='transfert'?'bi-send text-primary':'' ?>"></i>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="fw-bold"><?= ucfirst($t['type_transaction']) ?></div>
                                            <small class="text-muted">
                                                <?= $t['client_nom'] ?> (<?= $t['client_telephone'] ?>) <br>
                                                <?= $t['operateur'] ?> - <?= $t['operateur_numero'] ?> <br>
                                                <?= date('d/m/Y H:i', strtotime($t['created_at'])) ?>
                                            </small>
                                        </td>
                                        <td class="fw-bold <?= $t['type_transaction']=='depot'?'text-success':'text-danger' ?>">
                                            <?= $t['type_transaction']=='depot'?'+':'-' ?><?= number_format($t['montant'],0,',',' ') ?> Ar
                                        </td>
                                        <td class="text-end">
                                            <span class="badge bg-success bg-opacity-10 text-success px-3 py-2">Succès</span>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="4" class="text-center text-muted py-4">Aucune transaction</td>
                                </tr>
                            <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- ACTIONS -->
        <div class="col-xl-4">
            <div class="card actions-card p-4">
                <h5 class="fw-bold text-dark mb-4">Actions JHNi</h5>
                <div class="d-grid gap-3">
                    <a href="/transactions/create" class="btn btn-mm-primary d-flex align-items-center justify-content-center">
                        <i class="bi bi-plus-circle-fill me-2 fs-5"></i> Nouvelle Opération
                    </a>
                    
                </div>
            </div>
        </div>
    </div>

</div>

<!-- MODALE FILTRAGE PDF -->
<div class="modal fade" id="filterModal" tabindex="-1" aria-labelledby="filterModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <form method="GET" action="<?= base_url('dashboard/export_pdf') ?>">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="filterModalLabel">Filtrer les transactions</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fermer"></button>
        </div>
        <div class="modal-body">

          <div class="mb-3">
            <label class="form-label">Date début</label>
            <input type="date" class="form-control" name="date_start" required>
          </div>

          <div class="mb-3">
            <label class="form-label">Date fin</label>
            <input type="date" class="form-control" name="date_end" required>
          </div>

          <div class="mb-3">
            <label class="form-label">Type transaction</label>
            <select name="type_transaction" class="form-control">
              <option value="">Tous</option>
              <option value="depot">Dépôt</option>
              <option value="retrait">Retrait</option>
              <option value="transfer">Transfert</option>
            </select>
          </div>

          <div class="mb-3">
            <label class="form-label">Agence</label>
            <select name="agence_id" class="form-control">
              <option value="">Toutes</option>
              <?php foreach($agences as $a): ?>
              <option value="<?= $a['id'] ?>"><?= $a['nom'] ?></option>
              <?php endforeach; ?>
            </select>
          </div>

        </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-success">Exporter PDF</button>
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
        </div>
      </div>
    </form>
  </div>
</div>

<?= view('layout/footer') ?>