<?= view('layout/header') ?>

<style>
/* ================= STYLE GLOBAL (comme table) ================= */
.form-container {
    background: #fff;
    border-radius: 12px;
    padding: 25px;
    box-shadow: 0 10px 30px rgba(0,0,0,0.05);
    border: 1px solid #dee2e6;
    max-width: 800px;
    margin: auto;
}

/* Header style table */
.form-header {
    background-color: #002349;
    color: white;
    padding: 15px 20px;
    border-radius: 10px 10px 0 0;
    font-weight: 600;
    text-transform: uppercase;
    font-size: 0.9rem;
    letter-spacing: 0.5px;
}

/* Champs */
.form-control, .form-select {
    border-radius: 8px;
    padding: 10px;
}

/* Bouton */
.btn-submit {
    background-color: #002349;
    color: white;
    border-radius: 8px;
    padding: 12px;
    font-weight: 600;
    border: none;
}

.btn-submit:hover {
    background-color: #0d3b75;
    color: white;
}

/* Bloc rôles */
.roles-box {
    border: 1px solid #dee2e6;
    border-radius: 8px;
    padding: 15px;
    background: #f8fafc;
}
</style>

<div class="container py-5">

    <div class="form-container">

        <div class="form-header">
            👤 Création Utilisateur
        </div>

        <form method="post" action="/users/store" class="mt-4">

            <div class="row">

                <div class="col-md-6 mb-3">
                    <label class="form-label">Nom</label>
                    <input type="text" name="username" class="form-control" required>
                </div>

                <div class="col-md-6 mb-3">
                    <label class="form-label">Email</label>
                    <input type="email" name="email" class="form-control" required>
                </div>

                <div class="col-md-6 mb-3">
                    <label class="form-label">Mot de passe</label>
                    <input type="password" name="password" class="form-control" required>
                </div>

                <div class="col-md-6 mb-3">
                    <label class="form-label">Téléphone</label>
                    <input type="text" name="phone" class="form-control">
                </div>

                <div class="col-md-6 mb-3">
                    <label class="form-label">Agence</label>
                    <select name="agence_id" class="form-select">
                        <option value="">-- Sélectionnez une agence --</option>
                        <?php foreach($agences as $agence): ?>
                            <option value="<?= $agence['id'] ?>"><?= $agence['nom'] ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>

            </div>

            <div class="mb-3">
                <label class="form-label fw-bold">Rôles</label>
                <div class="roles-box">
                    <?php foreach($roles as $role): ?>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="roles[]" value="<?= $role['id'] ?>">
                            <label class="form-check-label"><?= $role['name'] ?></label>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>

            <div class="mb-3 form-check">
                <input type="checkbox" class="form-check-input" name="is_active" value="1" checked>
                <label class="form-check-label">Actif</label>
            </div>

            <div class="d-grid">
                <button class="btn-submit">
                    ➕ Créer Utilisateur
                </button>
            </div>

        </form>

    </div>

</div>

<?= view('layout/footer') ?>