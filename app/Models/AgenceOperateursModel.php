<?php

namespace App\Models;

use CodeIgniter\Model;

class AgenceOperateursModel extends Model
{
    protected $table = 'agence_operateurs';
    protected $primaryKey = 'id';
    protected $allowedFields = [
        'agence_id',
        'operateur_id',
        'operateur_numero_id',
        'solde_initial',
        'solde_actuel',
        'caisse_reelle',
        'created_at',
        'updated_at'
    ];

    protected $useTimestamps = true; // met automatiquement created_at et updated_at
}