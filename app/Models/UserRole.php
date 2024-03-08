<?php

namespace App\Models;

use CodeIgniter\Model;

class UserRole extends Model
{
    protected $table            = 'm_user_role';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $allowedFields    = ['id','role_id','role_name'];

    public function getAllUserRole() {
        return $this->select('id AS userId, role_id AS roleId, role_name AS userRoleName')
                    ->orderBy('id')
                    ->findAll();
    }
}
