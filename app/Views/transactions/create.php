<?= view('layout/header') ?>

<div class="container py-5">
    <div class="mb-5 border-start border-primary border-4 ps-3">
        <h2 class="fw-light mb-1">Nouvelle Transaction</h2>
        <p class="text-muted small text-uppercase tracking-wider">Enregistrement d'une opération financière</p>
    </div>

    <form method="post" action="/transactions/store" class="needs-validation">
        <div class="row g-4">
            
            <div class="col-lg-7">
                <div class="p-4 bg-white rounded-3 shadow-sm border border-light">
                    <label class="form-label text-muted small fw-bold">COORDONNÉES CLIENT</label>
                    <div class="row g-3">
                        <div class="col-md-6">
                            <input type="text" id="telephone" name="client_telephone" class="form-control form-control-flush" placeholder="Numéro de téléphone" required>
                        </div>
                        <div class="col-md-6">
                            <input type="text" id="nom_client" name="client_nom" class="form-control form-control-flush" placeholder="Nom complet du client" required>
                        </div>
                    </div>

                    <div class="mt-4 pt-3 border-top">
                        <label class="form-label text-muted small fw-bold mb-3">DÉTAILS DU TRANSFERT</label>
                        <div class="row g-3">
                            <div class="col-md-6">
                                <select name="type_transaction" class="form-select border-0 bg-light-subtle" required>
                                    <option value="" disabled selected>Type d'opération...</option>
                                    <option value="depot">Dépôt</option>
                                    <option value="retrait">Retrait</option>
                                    <option value="transfer">Transfert</option>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <select name="agence_id" class="form-select border-0 bg-light-subtle" required>
                                    <?php foreach($agences as $a): ?>
                                        <option value="<?= $a['id'] ?>"><?= $a['nom'] ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-5">
                <div class="p-4 bg-primary bg-opacity-10 rounded-3 border border-primary border-opacity-10 h-100">
                    <label class="form-label text-primary small fw-bold">MONTANTS & OPÉRATEUR</label>
                    
                    <div class="mb-3">
                        <select name="operateur_numero_id" class="form-select border-0 shadow-sm" required>
                            <option value="" disabled selected>Choisir l'opérateur...</option>
                            <?php foreach($operateur_numeros as $o): ?>
                                <option value="<?= $o['id'] ?>">
                                    <?= $o['operateur_nom'] ?> (<?= $o['numero'] ?>)
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="input-group mb-3 shadow-sm">
                        <span class="input-group-text border-0 bg-white text-muted small">Montant</span>
                        <input type="number" name="montant" class="form-control border-0 py-3 fw-bold text-primary text-end" placeholder="0" required>
                        <span class="input-group-text border-0 bg-white fw-bold text-primary">Ar</span>
                    </div>

                    <div class="row g-2 mb-4">
                        <div class="col-6">
                            <div class="input-group input-group-sm shadow-sm">
                                <input type="number" name="commission" class="form-control border-0" placeholder="Commission">
                                <span class="input-group-text border-0 bg-white text-muted">Ar</span>
                            </div>
                        </div>
                        <div class="col-6">
                            <input type="text" name="reference_operateur" class="form-control form-control-sm border-0 shadow-sm" placeholder="Référence">
                        </div>
                    </div>

                    <button type="submit" class="btn btn-primary w-100 py-3 rounded-pill shadow">
                        Confirmer la transaction
                    </button>
                    <a href="/transactions" class="btn btn-link w-100 text-muted mt-2 text-decoration-none small">Retour à la liste</a>
                </div>
            </div>

        </div>
    </form>
</div>

<?= view('layout/footer') ?>