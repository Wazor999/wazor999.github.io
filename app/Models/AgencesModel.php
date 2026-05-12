<?php
namespace App\Models;

use CodeIgniter\Model;

class AgencesModel extends Model
{
    protected $table = 'agences';
    protected $primaryKey = 'id';
    protected $allowedFields = ['nom', 'adresse', 'telephone', 'description'];
    protected $useTimestamps = true;
    protected $createdField  = 'date_creation';
    protected $updatedField  = 'date_modification';
}