<?= view('layout/header') ?>

<h3>Modifier Fonds Agence / Numéro Opérateur</h3>

<form method="post" action="/agence-operateurs/update/<?= $fonds['id'] ?>">

<div class="mb-3">
    <label>Agence</label>
    <select name="agence_id" class="form-control" required>
        <?php foreach($agences as $a): ?>
        <option value="<?= $a['id'] ?>" <?= $fonds['agence_id'] == $a['id'] ? 'selected' : '' ?>>
            <?= $a['nom'] ?>
        </option>
        <?php endforeach; ?>
    </select>
</div>

<div class="mb-3">
    <label>Numéro Opérateur</label>
    <select name="operateur_numero_id" class="form-control" required>
        <?php foreach($operateur_numeros as $n): ?>
        <option value="<?= $n['id'] ?>" <?= $fonds['operateur_numero_id'] == $n['id'] ? 'selected' : '' ?>>
            <?= $n['numero'] ?> (<?= $n['operateur_nom'] ?>)
        </option>
        <?php endforeach; ?>
    </select>
</div>

<div class="mb-3">
    <label>Solde Initial</label>
    <input type="number" name="solde_initial" value="<?= $fonds['solde_initial'] ?>" class="form-control" required>
</div>

<div class="mb-3">
    <label>Solde Actuel</label>
    <input type="number" name="solde_actuel" value="<?= $fonds['solde_actuel'] ?>" class="form-control" required>
</div>

<div class="mb-3">
    <label>Caisse Réelle</label>
    <input type="number" name="caisse_reelle" value="<?= $fonds['caisse_reelle'] ?>" class="form-control" required>
</div>

<button class="btn btn-success">Mettre à jour</button>

</form>

<?= view('layout/footer') ?>