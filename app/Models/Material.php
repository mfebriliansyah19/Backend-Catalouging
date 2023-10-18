<?php

namespace App\Models;

use CodeIgniter\Model;

class Material extends Model
{
    protected $table            = 'd_material';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $allowedFields    = ['material_number', 'part_number', 'raw_data', 'result', 'inc', 'mfr', 'group_code', 'where_used', 'cat', 'status', 'link'];

    // Mengambil Semua Data Material
    public function getAllMaterialData() {
        $materials = $this->select('d_material.material_number AS materialNumber, d_material.part_number AS partNumber, d_material.raw_data AS rawData, d_material.result, d_material.inc, d_material.mfr, d_material.group_code AS groupCode, d_material.where_used AS whereUsed, d_material.cat, d_material.status, d_material.link, m_inc.inc_name AS incName, d_attribute.attribute_code AS attributeCode, d_attribute.attribute_name AS attributeName, d_attribute.attribute_value AS attributeValue')
                ->join('m_inc', 'd_material.inc = m_inc.inc', 'left')
                ->join('d_attribute', 'd_material.inc = d_attribute.inc', 'left')
                ->orderBy('d_material.id')
                ->asArray()
                ->findAll();

        $result = [];

        foreach ($materials as $material) {
            $materialNumber = $material["materialNumber"];
            if (!isset($result[$materialNumber])) {
                $result[$materialNumber] = [
                    "materialNumber" => $material["materialNumber"],
                    "partNumber" => $material["partNumber"],
                    "rawData" => $material["rawData"],
                    "result" => $material["result"],
                    "inc" => $material["inc"],
                    "mfr" => $material["mfr"],
                    "groupCode" => $material["groupCode"],
                    "whereUsed" => $material["whereUsed"],
                    "cat" => $material["cat"],
                    "status" => $material["status"],
                    "link" => $material["link"],
                    "incName" => $material["incName"],
                    "attributes" => [],
                ];
            }

            $attribute = [
                "attributeCode" => $material["attributeCode"],
                "attributeName" => $material["attributeName"],
                "attributeValue" => $material["attributeValue"],
            ];

            $result[$materialNumber]["attributes"][] = $attribute;
        }

        $result = array_values($result);

        return $result;
    }

    // Assign / Update Cataloguer pada Material
    public function updateCat($id, $newCat) {
        $data = ['cat' => $newCat];
        return $this->update($id, $data);
    }
    
}
