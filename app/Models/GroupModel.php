<?php

namespace App\Models;

use CodeIgniter\Model;

class GroupModel extends Model
{
    protected $table            = 'm_group';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $allowedFields    = ['id', 'group_code', 'group_name'];

    public function getAllGroupData() {
        return $this->select('id, m_group.group_code AS groupCode, m_group.group_name AS groupName')
                    // ->join('m_inc', 'd_material.inc = m_inc.inc', 'left')
                    // ->join('d_attribute', 'd_material.inc = d_attribute.inc', 'left')
                    // ->groupBy('d_material.material_number')
                    ->orderBy('m_group.id')
                    // ->asArray()
                    ->findAll();
    }

}
