<?= view('layout/header') ?>

<style>
.user-card {
    max-width: 750px;
    margin: auto;
    border-radius: 20px;
    box-shadow: 0 10px 35px rgba(220, 53, 69, 0.15);
    border: none;
}

.user-header {
    background: linear-gradient(135deg, #dc3545, #ff6b6b);
    color: white;
    padding: 20px;
    border-radius: 20px 20px 0 0;
    font-weight: 600;
    font-size: 1.3rem;
}

.form-control, .form-select {
    border-radius: 10px;
    padding: 10px;
}

.btn-user {
    background: linear-gradient(135deg, #dc3545, #ff6b6b);
    border: none;
    color: white;
    border-radius: 12px;
    padding: 12px;
    font-weight: 600;
    box-shadow: 0 5px 15px rgba(220,53,69,0.2);
}

.btn-user:hover {
    background: linear-gradient(135deg, #bb2d3b, #ff4d4d);
    color: white;
}
</style>

<div class="container py-5">

    <div class="card user-card">
        <div class="user-header">
            👤 Modifier Utilisateur
        </div>

        <div class="card-body p-4">

            <form method="post" action="/users/update/<?= $user['id'] ?>">

                <div class="mb-3">
                    <label class="form-label">Nom</label>
                    <input type="text" name="username" value="<?= $user['username'] ?>" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Email</label>
                    <input type="email" name="email" value="<?= $user['email'] ?>" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Téléphone</label>
                    <input type="text" name="phone" value="<?= $user['phone'] ?>" class="form-control">
                </div>

                <div class="mb-3">
                    <label class="form-label">Agence</label>
                    <select name="agence_id" class="form-select">
                        <option value="">-- Sélectionnez une agence --</option>
                        <?php foreach($agences as $agence): ?>
                            <option value="<?= $agence['id'] ?>" <?= ($user['agence_id'] == $agence['id']) ? 'selected' : '' ?>>
                                <?= $agence['nom'] ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="mb-3">
                    <label class="form-label fw-bold">Rôles</label>
                    <div class="border rounded p-3">
                        <?php foreach($roles as $role): ?>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="roles[]"
                                       value="<?= $role['id'] ?>"
                                       <?= in_array($role['id'], $userRoleIds) ? 'checked' : '' ?>>
                                <label class="form-check-label"><?= $role['name'] ?></label>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>

                <div class="mb-3 form-check">
                    <input type="checkbox" class="form-check-input" name="is_active" value="1"
                           <?= ($user['is_active'] == 1) ? 'checked' : '' ?>>
                    <label class="form-check-label">Actif</label>
                </div>

                <div class="d-grid">
                    <button class="btn btn-user">
                        💾 Mettre à jour
                    </button>
                </div>

            </form>

        </div>
    </div>

</div>

<?= view('layout/footer') ?>