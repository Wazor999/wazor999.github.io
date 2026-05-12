<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="UTF-8">
<style>
    /* Configuration pour imprimante thermique 80mm */
    @page {
        margin: 0;
        size: 80mm 297mm;
    }

    body {
        font-family: 'Courier New', Courier, monospace;
        font-size: 13px;
        width: 72mm; /* Largeur d'impression réelle */
        margin: 0;
        padding-top: 5mm;
        padding-left: 2mm;  /* Marge à gauche */
        padding-right: 4mm; /* Marge à droite pour plus de sécurité */
        box-sizing: border-box; /* Assure que le padding ne dépasse pas la largeur */
        color: #000;
        background-color: #fff;
    }

    .center { text-align: center; margin-right: 2mm; } /* Compensation pour centrer visuellement */
    .bold { font-weight: bold; }
    .uppercase { text-transform: uppercase; }

    hr {
        border: none;
        border-top: 1px dashed #000;
        margin: 10px 0;
        width: 100%;
    }

    .line {
        display: flex;
        justify-content: space-between;
        margin-bottom: 2px;
    }

    .small { font-size: 11px; }

    @media print {
        body { width: 72mm; }
    }
</style>
</head>
<body>

<div class="center bold" style="font-size: 16px;">
    JHNi SERVICES
</div>

<div class="center small">
    Mobile-Money<br>
    Antananarivo
</div>

<hr>

<div class="small">
    <div class="line"><span>DATE:</span> <span><?= date('d/m/Y', strtotime($transaction['created_at'])) ?></span></div>
    <div class="line"><span>HEURE:</span> <span><?= date('H:i', strtotime($transaction['created_at'])) ?></span></div>
    <div class="line"><span>TICKET:</span> <span>#<?= str_pad($transaction['id'], 6, '0', STR_PAD_LEFT) ?></span></div>
    <div class="line"><span>AGENCE:</span> <span><?= esc($transaction['agence']) ?></span></div>
    <div class="line"><span>AGENT:</span> <span><?= esc($transaction['agent']) ?></span></div>
</div>

<hr>

<div class="small">
    <div class="line uppercase"><strong>TYPE:</strong> <span><?= strtoupper($transaction['type_transaction']) ?></span></div>
    <div class="line"><strong>CLIENT:</strong> <span><?= esc($transaction['client_nom']) ?></span></div>
    <div class="line"><strong>TEL:</strong> <span><?= esc($transaction['client_telephone']) ?></span></div>
</div>

<hr>

<div class="line">
    <span>MONTANT</span>
    <span><?= number_format($transaction['montant'],0,',',' ') ?> Ar</span>
</div>

<div class="line">
    <span>FRAIS</span>
    <span><?= number_format($transaction['commission'],0,',',' ') ?> Ar</span>
</div>

<hr>

<div class="line bold" style="font-size: 14px;">
    <span>TOTAL</span>
    <span><?= number_format($transaction['montant'] + $transaction['commission'],0,',',' ') ?> Ar</span>
</div>

<hr>

<div class="center small">
    REF : <?= esc($transaction['reference_operateur']) ?><br>
    <strong>STATUT : SUCCES</strong>
</div>

<hr>

<div class="center small">
    Merci pour votre confiance 🙏<br>
    <br>
    .
</div>

</body>
</html>