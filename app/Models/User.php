<?php

namespace App\Models;

use CodeIgniter\Model;

class User extends Model
{
    protected $table            = 'user';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $allowedFields    = ['name','password','role_id'];

    public function getAllUserData() {
        return $this->select('user.id AS userId, user.name AS userName, user.role_id AS userRoleId, m_user_role.role_name AS userRole')
                    ->join('m_user_role', 'user.role_id = m_user_role.role_id', 'left')
                    ->orderBy('user.id')
                    // ->asArray()
                    ->findAll();
    }

    // public function getCatUser() {
    //     return $this->select('user.id AS userId, user.name AS userName, m_user_role.role_name AS userRole')
    //                 ->where(['user.role_id' => 4])
    //                 ->join('m_user_role', 'user.role_id = m_user_role.role_id', 'left')
    //                 ->orderBy('user.id')
    //                 // ->asArray()
    //                 ->findAll();
    // }
    public function getUserByRole($id) {
        return $this->select('user.id AS userId, user.name AS userName, m_user_role.role_name AS userRole')
                    ->where(['user.role_id' => $id])
                    ->join('m_user_role', 'user.role_id = m_user_role.role_id', 'left')
                    ->orderBy('user.id')
                    // ->asArray()
                    ->findAll();
    }
    // Dates
    // protected $useTimestamps = true;
    // protected $dateFormat    = 'datetime';
    // protected $createdField  = 'created_at';
    // protected $updatedField  = 'updated_at';
    // protected $deletedField  = 'deleted_at';

    // Validation
    // protected $validationRules      = [];
    // protected $validationMessages   = [];
    // protected $skipValidation       = false;
    // protected $cleanValidationRules = true;

    // Callbacks
    // protected $allowCallbacks = true;
    // protected $beforeInsert   = [];
    // protected $afterInsert    = [];
    // protected $beforeUpdate   = [];
    // protected $afterUpdate    = [];
    // protected $beforeFind     = [];
    // protected $afterFind      = [];
    // protected $beforeDelete   = [];
    // protected $afterDelete    = [];
}
