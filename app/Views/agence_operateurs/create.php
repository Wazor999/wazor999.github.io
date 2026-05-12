<?= view('layout/header') ?>

<h3>Ajouter Fonds par Numéro Opérateur</h3>

<?php if(session()->getFlashdata('error')): ?>
<div class="alert alert-danger">
    <?= session()->getFlashdata('error') ?>
</div>
<?php endif; ?>

<form method="post" action="<?= base_url('agence-operateurs/store') ?>">

    <div class="mb-3">
        <label>Agence</label>
        <select name="agence_id" class="form-control" required>
            <option value="">Choisir agence</option>
            <?php foreach($agences as $a): ?>
            <option value="<?= $a['id'] ?>"><?= $a['nom'] ?></option>
            <?php endforeach; ?>
        </select>
    </div>

    <div class="mb-3">
        <label>Numéro Opérateur</label>
        <select name="operateur_numero_id" class="form-control" required>
            <option value="">Choisir numéro</option>
            <?php foreach($operateur_numeros as $n): ?>
            <option value="<?= $n['id'] ?>"><?= $n['numero'] ?> (<?= $n['operateur_nom'] ?>)</option>
            <?php endforeach; ?>
        </select>
    </div>

    <div class="mb-3">
        <label>Solde initial</label>
        <input type="number" name="solde_initial" value="<?= old('solde_initial') ?>" class="form-control" required>
    </div>

    <button class="btn btn-primary">Enregistrer</button>

</form>

<?= view('layout/footer') ?>