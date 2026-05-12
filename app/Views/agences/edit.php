<?= view('layout/header') ?>

<div class="container py-5">

    <div class="row justify-content-center">
        <div class="col-md-6">

            <div class="card shadow-lg border-0 rounded-4">
                <div class="card-header bg-success text-white rounded-top-4">
                    <h5 class="mb-0">
                        <i class="bi bi-building me-2"></i>
                        Modifier Agence
                    </h5>
                </div>

                <div class="card-body p-4">

                    <form method="post" action="<?= base_url('agences/update/'.$agence['id']) ?>">

                        <!-- NOM -->
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Nom</label>
                            <input 
                                type="text" 
                                name="nom" 
                                value="<?= esc($agence['nom']) ?>" 
                                class="form-control" 
                                required>
                        </div>

                        <!-- ADRESSE -->
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Adresse</label>
                            <input 
                                type="text" 
                                name="adresse" 
                                value="<?= esc($agence['adresse']) ?>" 
                                class="form-control">
                        </div>

                        <!-- TELEPHONE -->
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Téléphone</label>
                            <input 
                                type="text" 
                                name="telephone" 
                                value="<?= esc($agence['telephone']) ?>" 
                                class="form-control">
                        </div>

                        <!-- DESCRIPTION -->
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Description</label>
                            <input 
                                type="text" 
                                name="description" 
                                value="<?= esc($agence['description']) ?>" 
                                class="form-control">
                        </div>

                        <!-- BOUTONS -->
                        <div class="d-flex justify-content-between mt-4">
                            <a href="<?= base_url('agences') ?>" class="btn btn-secondary rounded-pill px-4">
                                <i class="bi bi-arrow-left me-1"></i> Retour
                            </a>

                            <button class="btn btn-success rounded-pill px-4">
                                <i class="bi bi-check-circle me-1"></i> Mettre à jour
                            </button>
                        </div>

                    </form>

                </div>
            </div>

        </div>
    </div>

</div>

<?= view('layout/footer') ?>