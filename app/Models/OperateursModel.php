<?php
namespace App\Models;

use CodeIgniter\Model;

class OperateursModel extends Model
{
    protected $table = 'operateurs';
    protected $primaryKey = 'id';
    protected $allowedFields = ['nom','description','date_creation','date_modification'];
    protected $useTimestamps = true;
    protected $createdField  = 'date_creation';
    protected $updatedField  = 'date_modification';
}