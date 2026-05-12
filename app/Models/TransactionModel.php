<?php

namespace App\Models;

use CodeIgniter\Model;

class TransactionModel extends Model
{
    protected $table = 'transactions';
    protected $primaryKey = 'id';

    protected $allowedFields = [
        'user_id',
        'client_id',
        'agence_id',
        'operateur_numero_id',
        'type_transaction',
        'montant',
        'commission',
        'reference_operateur'
    ];

    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
}