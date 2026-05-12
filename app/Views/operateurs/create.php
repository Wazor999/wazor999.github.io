<?= view('layout/header') ?>

<div class="container py-5">

    <div class="row justify-content-center">
        <div class="col-md-6">

            <div class="card shadow-lg border-0 rounded-4">
                <div class="card-header bg-primary text-white rounded-top-4">
                    <h5 class="mb-0">
                        <i class="bi bi-plus-circle me-2"></i>
                        Ajouter Numéro d'Opérateur
                    </h5>
                </div>

                <div class="card-body p-4">

                    <!-- MESSAGE ERREUR -->
                    <?php if(session()->getFlashdata('error')): ?>
                        <div class="alert alert-danger">
                            <?= session()->getFlashdata('error') ?>
                        </div>
                    <?php endif; ?>

                    <form method="post" action="<?= base_url('operateurs/store') ?>">

                        <!-- OPERATEUR -->
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Opérateur</label>
                            <select name="operateur_id" class="form-control" required>
                                <option value="">-- Sélectionner --</option>
                                <?php foreach($operateurs as $o): ?>
                                    <option value="<?= $o['id'] ?>">
                                        <?= esc($o['nom']) ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <!-- NUMERO -->
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Numéro</label>
                            <input 
                                type="text" 
                                name="numero" 
                                class="form-control" 
                                placeholder="034xxxxxxx"
                                required>
                        </div>

                        <!-- DESCRIPTION -->
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Description</label>
                            <input 
                                type="text" 
                                name="description" 
                                class="form-control"
                                placeholder="Optionnel">
                        </div>

                        <!-- BOUTONS -->
                        <div class="d-flex justify-content-between mt-4">
                            <a href="<?= base_url('operateurs') ?>" class="btn btn-secondary rounded-pill px-4">
                                <i class="bi bi-arrow-left me-1"></i> Retour
                            </a>

                            <button type="submit" class="btn btn-primary rounded-pill px-4">
                                <i class="bi bi-check-circle me-1"></i> Enregistrer
                            </button>
                        </div>

                    </form>

                </div>
            </div>

        </div>
    </div>

</div>

<?= view('layout/footer') ?>