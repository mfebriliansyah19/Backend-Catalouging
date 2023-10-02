<?php

namespace App\Models;

use CodeIgniter\Model;

class Attribute extends Model
{
    protected $table            = 'd_attribute';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $allowedFields    = ['inc','attribute_code','attribute_name','attribute_value'];

    public function getAllAttributeData() {
        return $this->select('d_attribute.inc AS inc, d_attribute.attribute_code AS attributeCode, d_attribute.attribute_name AS attributeName, d_attribute.attribute_value AS attributeValue')
                    ->join('m_inc', 'd_attribute.inc = m_inc.inc', 'left')
                    // ->join('d_attribute', 'd_material.inc = d_attribute.inc', 'left')
                    // ->groupBy('d_material.material_number')
                    ->orderBy('d_attribute.id')
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
