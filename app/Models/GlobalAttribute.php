<?php

namespace App\Models;

use CodeIgniter\Model;

class GlobalAttribute extends Model
{
    protected $table            = 'd_global_attribute';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $allowedFields    = ['id','attribute_code','attribute_name','created_at','updated_at'];
    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';

    public function getAllGlobalAttributeData() {
        return $this->select('id, d_global_attribute.attribute_code AS globalattributeCode, d_global_attribute.attribute_name AS globalattributeName, d_global_attribute.created_at AS globalCreated, d_global_attribute.updated_at AS globalUpdated')
                    ->orderBy('d_global_attribute.id')
                    ->findAll();
    }
}
