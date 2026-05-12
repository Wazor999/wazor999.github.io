<?php
namespace App\Models;

use CodeIgniter\Model;

class OperateurNumerosModel extends Model
{
    protected $table = 'operateur_numeros';
    protected $primaryKey = 'id';
    protected $allowedFields = ['operateur_id','numero','description','created_at','updated_at'];
    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
}