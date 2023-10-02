<?php

namespace App\Models;

use CodeIgniter\Model;

class Inc extends Model
{
    protected $table            = 'm_inc';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $allowedFields    = ['INC','INC_NAME'];

    public function getAllIncData() {
        return $this->select('m_inc.INC AS INC, m_inc.INC_NAME AS INCName')
                    // ->join('m_inc', 'd_material.inc = m_inc.inc', 'left')
                    // ->join('d_attribute', 'd_material.inc = d_attribute.inc', 'left')
                    // ->groupBy('d_material.material_number')
                    ->orderBy('m_inc.id')
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
