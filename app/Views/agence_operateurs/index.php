<?= view('layout/header') ?>

<h3>Fonds par Agence / Numéro Opérateur</h3>

<a href="/agence-operateurs/create" class="btn btn-primary mb-3">Ajouter Fonds</a>

<table class="table table-bordered table-striped table-hover">
<thead class="table-dark">
<tr>
    <th>ID</th>
    <th>Agence</th>
    <th>Numéro / Opérateur</th>
    <th>Solde Initial</th>
    <th>Solde Actuel</th>
    <th>Caisse Réelle</th>
    <th>Action</th>
</tr>
</thead>

<tbody>
<?php if(!empty($fonds)): ?>
    <?php foreach($fonds as $f): ?>
    <tr>
        <td><?= $f['id'] ?></td>
        <td><?= $f['agence_nom'] ?></td>
        <td><?= $f['numero'] ?> (<?= $f['operateur_nom'] ?>)</td>
        <td><?= number_format($f['solde_initial'],0,',',' ') ?> Ar</td>
        <td><?= number_format($f['solde_actuel'],0,',',' ') ?> Ar</td>
        <td><?= number_format($f['caisse_reelle'],0,',',' ') ?> Ar</td>
        <td>
            <a href="/agence-operateurs/edit/<?= $f['id'] ?>" class="btn btn-warning btn-sm">Edit</a>
            <a href="/agence-operateurs/delete/<?= $f['id'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('Supprimer ?')">Delete</a>
        </td>
    </tr>
    <?php endforeach; ?>
<?php else: ?>
<tr><td colspan="7" class="text-center text-muted">Aucun fonds enregistré</td></tr>
<?php endif; ?>
</tbody>
</table>

<?= view('layout/footer') ?>