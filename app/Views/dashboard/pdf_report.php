<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="UTF-8">
<title>Rapport Transactions Mobile Money</title>
<style>
    body { font-family: Arial, sans-serif; font-size: 12px; }
    h1, h2, h3 { text-align: center; margin: 5px 0; }
    table { width: 100%; border-collapse: collapse; margin-top: 10px; font-size: 12px; }
    th, td { border: 1px solid #333; padding: 5px; text-align: left; }
    th { background-color: #001f3f; color: #fff; font-size: 11px; }
    .text-center { text-align: center; }
    .text-right { text-align: right; }
    tfoot td { font-weight: bold; background-color: #f4f4f4; }
</style>
</head>
<body>

<h1>RAPPORT DE TRANSACTIONS DE MOBILE MONEY</h1>
<h2>Agence : <?= esc($agenceNom ?? 'Toutes') ?></h2>
<h3>Période : <?= esc($dateStart) ?> au <?= esc($dateEnd) ?></h3>

<!-- ===================== Résumé global ===================== -->
<h3>Résumé Global</h3>
<table>
    <thead>
        <tr>
            <th>Type</th>
            <th>Nombre</th>
            <th>Montant Total (Ar)</th>
            <th>Commission Totale (Ar)</th>
        </tr>
    </thead>
    <tbody>
        <?php 
            $totalMontant = 0;
            $totalCommission = 0;
        ?>
        <?php if(!empty($resume)): ?>
            <?php foreach($resume as $type => $r): 
                $totalMontant += $r['montant_total'];
                $totalCommission += $r['commission_total'];
            ?>
            <tr>
                <td><?= esc($type) ?></td>
                <td class="text-center"><?= $r['nombre'] ?></td>
                <td class="text-right"><?= number_format($r['montant_total'],0,',',' ') ?></td>
                <td class="text-right"><?= number_format($r['commission_total'],0,',',' ') ?></td>
            </tr>
            <?php endforeach; ?>
        <?php else: ?>
            <tr>
                <td colspan="4" class="text-center">Aucune donnée</td>
            </tr>
        <?php endif; ?>
    </tbody>
    <tfoot>
        <tr>
            <td class="text-center" colspan="2">TOTAL</td>
            <td class="text-right"><?= number_format($totalMontant,0,',',' ') ?></td>
            <td class="text-right"><?= number_format($totalCommission,0,',',' ') ?></td>
        </tr>
    </tfoot>
</table>

<!-- ===================== Historique détaillé ===================== -->
<h3>Historique détaillé des transactions</h3>
<table>
    <thead>
        <tr>
            <th>Date/Heure</th>
            <th>Agent</th>
            <th>Agence</th>
            <th>Opérateur - N°</th>
            <th>Client - Tél</th>
            <th>Type</th>
            <th>Montant (Ar)</th>
            <th>Frais / Com° (Ar)</th>
            <th>Réference</th>
        </tr>
    </thead>
    <tbody>
        <?php 
            $totalMontantHisto = 0;
            $totalCommissionHisto = 0;
        ?>
        <?php if(!empty($transactions)): ?>
            <?php foreach($transactions as $t): 
                $totalMontantHisto += $t['montant'];
                $totalCommissionHisto += $t['commission'];
            ?>
            <tr>
                <td><?= date('d/m/Y H:i', strtotime($t['created_at'])) ?></td>
                <td><?= esc($t['agent']) ?></td>
                <td><?= esc($t['agence']) ?></td>
                <td><?= esc($t['operateur']) ?> - <?= esc($t['operateur_numero']) ?></td>
                <td><?= esc($t['client_nom']) ?> - <?= esc($t['client_telephone']) ?></td>
                <td><?= esc($t['type_transaction']) ?></td>
                <td class="text-right"><?= number_format($t['montant'],0,',',' ') ?></td>
                <td class="text-right"><?= number_format($t['commission'],0,',',' ') ?></td>
                <td><?= esc($t['reference_operateur'] ?? '-') ?></td>
            </tr>
            <?php endforeach; ?>
        <?php else: ?>
            <tr>
                <td colspan="9" class="text-center">Aucune transaction trouvée</td>
            </tr>
        <?php endif; ?>
    </tbody>
    <tfoot>
        <tr>
            <td colspan="6" class="text-center">TOTAL</td>
            <td class="text-right"><?= number_format($totalMontantHisto,0,',',' ') ?></td>
            <td class="text-right"><?= number_format($totalCommissionHisto,0,',',' ') ?></td>
            <td></td>
        </tr>
    </tfoot>
</table>

</body>
</html>