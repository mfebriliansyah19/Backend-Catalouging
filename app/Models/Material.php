<?php

namespace App\Models;

use CodeIgniter\Model;

class Material extends Model
{
    protected $table            = 'd_material';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $allowedFields    = ['material_number', 'part_number', 'raw_data', 'raw_data2', 'raw_data3', 'raw_data4', 'flag1', 'flag2', 'result', 'inc', 'mfr', 'group_code', 'cat', 'status', 'link'];

    // Mengambil Semua Data Material
    public function getAllMaterialData() {
        $materials = $this->select('d_material.id, d_material.material_number AS materialNumber, d_material.part_number AS partNumber, d_material.raw_data AS rawData, d_material.raw_data2 AS rawData2, d_material.raw_data3 AS rawData3, d_material.raw_data4 AS rawData4, d_material.flag1 AS flag1, d_material.flag2 AS flag2, d_material.result, d_material.inc, d_material.mfr, d_material.group_code AS groupCode, d_material.cat, d_material.status, d_material.link, m_inc.inc_name AS incName, d_attribute.attribute_code AS attributeCode, d_attribute.attribute_name AS attributeName, d_attribute.attribute_value AS attributeValue')
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
                    "id" => $material["id"],
                    "materialNumber" => $material["materialNumber"],
                    "partNumber" => $material["partNumber"],
                    "rawData" => $material["rawData"],
                    "rawData2" => $material["rawData2"],
                    "rawData3" => $material["rawData3"],
                    "rawData4" => $material["rawData4"],
                    "flag1" => $material["flag1"],
                    "flag2" => $material["flag2"],
                    "result" => $material["result"],
                    "inc" => $material["inc"],
                    "mfr" => $material["mfr"],
                    "groupCode" => $material["groupCode"],
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

    public function updateINC($id, $inc)
    {
        $this->where('id', $id)->set(['inc' => $inc])->update();
    }

    // Assign / Update Cataloguer pada Material
    public function updateCat($id, $newCat) {
        $data = ['cat' => $newCat];
        return $this->update($id, $data);
    }
    
}