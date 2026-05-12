<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Ticket Transaction #<?= $transaction['id'] ?></title>
    <style>
        body { font-family: Arial, sans-serif; font-size: 12px; margin: 0; padding: 10px; width: 240px; }
        h2 { text-align: center; font-size: 14px; margin: 0; }
        p { margin: 2px 0; }
        table { width: 100%; border-collapse: collapse; margin-top: 5px; }
        th, td { padding: 3px 0; text-align: left; }
        th { font-weight: bold; }
        .center { text-align: center; }
        .total { font-weight: bold; font-size: 13px; }
        hr { border: 0; border-top: 1px dashed #000; margin: 5px 0; }
    </style>
</head>
<body>
    <h2>JHNI</h2>
    <p class="center">Service Mobile Money</p>
    <hr>
    <p><strong>Date:</strong> <?= date('d/m/Y', strtotime($transaction['created_at'])) ?></p>
    <p><strong>Heure:</strong> <?= date('H:i', strtotime($transaction['created_at'])) ?></p>
    <p><strong>Ticket #:</strong> CE<?= str_pad($transaction['id'], 6, '0', STR_PAD_LEFT) ?></p>
    <p><strong>Agence:</strong> <?= htmlspecialchars($transaction['agence']) ?></p>
    <hr>
    <p><strong>Type d'opération:</strong> <?= ucfirst($transaction['type_transaction']) ?></p>
    <p><strong>Client:</strong> <?= htmlspecialchars($transaction['client_nom']) ?></p>
    <p><strong>N° Mobile:</strong> <?= htmlspecialchars($transaction['client_telephone']) ?></p>
    <p><strong>Réf. Réseau:</strong> <?= htmlspecialchars($transaction['reference_operateur']) ?></p>
    <p><strong>Montant Net:</strong> <?= number_format($transaction['montant'],0,',',' ') ?> Ar</p>
    <p><strong>Frais Réseau:</strong> <?= number_format($transaction['commission'],0,',',' ') ?> Ar</p>
    <p class="total">TOTAL PAYÉ: <?= number_format($transaction['montant'] + $transaction['commission'],0,',',' ') ?> Ar</p>
    <hr>
    <p><strong>Statut:</strong> Réussie</p>
    <p class="center">Merci de votre confiance !</p>
    <div class="center">
        <img src="https://api.qrserver.com/v1/create-qr-code/?size=80x80&data=<?= urlencode($transaction['reference_operateur']) ?>" alt="QR Code">
    </div>
</body>
</html>