<?php

namespace App\Models;

use CodeIgniter\Model;

class ClientModel extends Model
{
    protected $table = 'clients';
    protected $primaryKey = 'id';

    protected $allowedFields = [
        'nom',
        'telephone',
        'created_at',
        'updated_at'
    ];

    protected $useTimestamps = true;
}