<?= view('layout/header') ?>

<div class="container py-5">

    <div class="row justify-content-center">
        <div class="col-md-6">

            <div class="card shadow-lg border-0 rounded-4">
                <div class="card-header bg-success text-white rounded-top-4">
                    <h5 class="mb-0">
                        <i class="bi bi-building-add me-2"></i>
                        Ajouter Agence
                    </h5>
                </div>

                <div class="card-body p-4">

                    <!-- MESSAGE ERREUR -->
                    <?php if(session()->getFlashdata('error')): ?>
                        <div class="alert alert-danger">
                            <?= session()->getFlashdata('error') ?>
                        </div>
                    <?php endif; ?>

                    <form method="post" action="<?= base_url('agences/store') ?>">

                        <!-- NOM -->
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Nom</label>
                            <input 
                                type="text" 
                                name="nom" 
                                class="form-control" 
                                placeholder="Nom de l'agence"
                                required>
                        </div>

                        <!-- ADRESSE -->
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Adresse</label>
                            <input 
                                type="text" 
                                name="adresse" 
                                class="form-control"
                                placeholder="Adresse de l'agence">
                        </div>

                        <!-- TELEPHONE -->
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Téléphone</label>
                            <input 
                                type="text" 
                                name="telephone" 
                                class="form-control"
                                placeholder="034xxxxxxx">
                        </div>

                        <!-- DESCRIPTION -->
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Description</label>
                            <input 
                                type="text" 
                                name="description" 
                                class="form-control"
                                placeholder="Description (optionnel)">
                        </div>

                        <!-- BOUTONS -->
                        <div class="d-flex justify-content-between mt-4">
                            <a href="<?= base_url('agences') ?>" class="btn btn-secondary rounded-pill px-4">
                                <i class="bi bi-arrow-left me-1"></i> Retour
                            </a>

                            <button type="submit" class="btn btn-success rounded-pill px-4">
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