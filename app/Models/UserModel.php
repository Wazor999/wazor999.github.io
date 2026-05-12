<?php
namespace App\Models;
use CodeIgniter\Model;

class UserModel extends Model
{
    protected $table = 'users';
    protected $primaryKey = 'id';

    protected $allowedFields = [
        'username',
        'email',
        'password',   // ✅ FIX
        'agence_id',
        'phone',      // ✅ FIX
        'is_active'
    ];

    public function getUsersWithRoles($perPage = 10)
    {
        return $this->select('users.*, agences.nom as agence_nom, GROUP_CONCAT(r.name) as roles')
                    ->join('agences', 'agences.id = users.agence_id', 'left')
                    ->join('user_roles ur', 'ur.user_id = users.id', 'left')
                    ->join('roles r', 'r.id = ur.role_id', 'left')
                    ->groupBy('users.id')
                    ->paginate($perPage);
    }
}