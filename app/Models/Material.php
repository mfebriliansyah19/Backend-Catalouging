<?php

namespace App\Models;

use CodeIgniter\Model;

class Material extends Model
{
    protected $table            = 'd_material';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $allowedFields    = ['material_number', 'part_number', 'raw_data', 'raw_data2', 'raw_data3', 'raw_data4', 'flag1', 'flag2', 'result', 'attribute_value', 'global_attribute_value', 'inc', 'mfr', 'group_code', 'cat', 'qc', 'status', 'link', 'complete_live_description', 'history_complete_desc'];

    // Mengambil Semua Data Material
    public function getAllMaterialData($page = 1, $perPage = 50) {

        $offset = ($page - 1) * $perPage;
        $offset = max(0, $offset);

        $materials = $this->select('d_material.id, d_material.material_number AS materialNumber, d_material.part_number AS partNumber, d_material.raw_data AS rawData, d_material.raw_data2 AS rawData2, d_material.raw_data3 AS rawData3, d_material.raw_data4 AS rawData4, d_material.flag1 AS flag1, d_material.flag2 AS flag2, d_material.result, d_material.attribute_value AS attributeValue, d_material.global_attribute_value AS globalAttributeValue, d_material.inc, d_material.mfr, d_material.group_code AS groupCode, d_material.cat, d_material.qc, d_material.status, d_material.link, d_material.complete_live_description AS completeDesc, d_material.history_complete_desc AS historyDesc, m_inc.inc_name AS incName, d_attribute.attribute_code AS attributeCode, d_attribute.attribute_name AS attributeName, d_attribute.sequence, m_group.group_name AS groupName')
                ->join('m_inc', 'd_material.inc = m_inc.inc', 'left')
                ->join('d_attribute', 'd_material.inc = d_attribute.inc', 'left')
                ->join('m_group', 'd_material.group_code = m_group.group_code', 'left')
                ->orderBy('d_material.id')
                ->asArray()
                ->findAll($perPage, $offset);

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
                    "groupName" => $material["groupName"],
                    "cat" => $material["cat"],
                    "qc" => $material["qc"],
                    "status" => $material["status"],
                    "link" => $material["link"],
                    "completeDesc" => $material["completeDesc"],
                    "historyDesc" => $material["historyDesc"],
                    "incName" => $material["incName"],
                    "attributes" => [],
                    "attributeValue" => $material["attributeValue"],
                    "globalAttributeValue" => $material["globalAttributeValue"],
                ];
            }

            $attribute = [
                "attributeCode" => $material["attributeCode"],
                "attributeName" => $material["attributeName"],
                "sequence" => $material["sequence"],
            ];

            $result[$materialNumber]["attributes"][] = $attribute;
        }

        foreach ($result as &$materialData) {
            usort($materialData["attributes"], function ($a, $b) {
                return $a["sequence"] - $b["sequence"];
            });
        }
        unset($materialData);

        $result = array_values($result);
        // var_dump('Haloo');

        return $result;
    }

    // public function searchMaterialData($page, $perPage, $searchQueries)
    // {
    //     $offset = ($page - 1) * $perPage;
    //     $offset = max(0, $offset);

    //     $builder = $this->db->table('d_material');

    //     $builder->select('d_material.id, d_material.material_number AS materialNumber, d_material.part_number AS partNumber, d_material.raw_data AS rawData, d_material.raw_data2 AS rawData2, d_material.raw_data3 AS rawData3, d_material.raw_data4 AS rawData4, d_material.flag1 AS flag1, d_material.flag2 AS flag2, d_material.result, d_material.attribute_value AS attributeValue, d_material.global_attribute_value AS globalAttributeValue, d_material.inc, d_material.mfr, d_material.group_code AS groupCode, d_material.cat, d_material.qc, d_material.status, d_material.link, d_material.complete_live_description AS completeDesc, d_material.history_complete_desc AS historyDesc, m_inc.inc_name AS incName, m_group.group_name AS groupName');
    //     $builder->join('m_inc', 'd_material.inc = m_inc.inc', 'left');
    //     $builder->join('m_group', 'd_material.group_code = m_group.group_code', 'left');
    //     $builder->orderBy('d_material.id');

    //     // Constructing the search conditions
    //     foreach ($searchQueries as $key => $value) {
    //         if (!empty($value)) {
    //             switch ($key) {
    //                 case 'searchInc':
    //                     $builder->like('d_material.inc', '%' . $value . '%');
    //                     break;
    //                 case 'searchMfr':
    //                     $builder->like('d_material.mfr', '%' . $value . '%');
    //                     break;
    //                 case 'searchPartNumber':
    //                     $builder->like('d_material.part_number', '%' . $value . '%');
    //                     break;
    //                 case 'searchDescriptionAfter':
    //                     $builder->like('d_material.result', '%' . $value . '%');
    //                     break;
    //                 case 'searchNumber':
    //                     $builder->like('d_material.material_number', '%' . $value . '%');
    //                     break;
    //                 case 'searchFlag1':
    //                     $builder->like('d_material.flag1', '%' . $value . '%');
    //                     break;
    //                 case 'searchStatus':
    //                     $builder->like('d_material.status', '%' . $value . '%');
    //                     break;
    //                 case 'searchDescriptionBefore':
    //                     $builder->like('d_material.raw_data', '%' . $value . '%');
    //                     break;
    //                 case 'searchAll':
    //                     // Search in every column
    //                     $allowedFields = [
    //                         'd_material.inc',
    //                         'd_material.mfr',
    //                         'd_material.part_number',
    //                         'd_material.result',
    //                         'd_material.material_number',
    //                         'd_material.flag1',
    //                         'd_material.status',
    //                         'd_material.raw_data'
    //                     ];
    //                     $builder->groupStart();
    //                     foreach ($allowedFields as $field) {
    //                         $builder->orLike($field, '%' . $value . '%');
    //                     }
    //                     $builder->groupEnd();
    //                     break;
    //             }
    //         }
    //     }

    //     // Getting total count of results without pagination
    //     $totalResults = $builder->countAllResults(false);

    //     // Applying pagination and fetching data
    //     $builder->limit($perPage, $offset);

    //     $materials = $builder->get()->getResult();

    //     return ['materials' => $materials, 'totalResults' => $totalResults];
    // }

    public function searchMaterialData($page, $perPage, $searchQueries)
{
    $offset = ($page - 1) * $perPage;
    $offset = max(0, $offset);

    $builder = $this->db->table('d_material');

    $builder->select('d_material.id, d_material.material_number AS materialNumber, d_material.part_number AS partNumber, d_material.raw_data AS rawData, d_material.raw_data2 AS rawData2, d_material.raw_data3 AS rawData3, d_material.raw_data4 AS rawData4, d_material.flag1 AS flag1, d_material.flag2 AS flag2, d_material.result, d_material.attribute_value AS attributeValue, d_material.global_attribute_value AS globalAttributeValue, d_material.inc, d_material.mfr, d_material.group_code AS groupCode, d_material.cat, d_material.qc, d_material.status, d_material.link, d_material.complete_live_description AS completeDesc, d_material.history_complete_desc AS historyDesc, m_inc.inc_name AS incName, m_group.group_name AS groupName');
    $builder->join('m_inc', 'd_material.inc = m_inc.inc', 'left');
    $builder->join('m_group', 'd_material.group_code = m_group.group_code', 'left');
    $builder->orderBy('d_material.id');

    // Constructing the search conditions
    foreach ($searchQueries as $key => $value) {
        if (!empty($value)) {
            switch ($key) {
                case 'searchInc':
                    if (strpos($value, '||') !== false) {
                        $subKeywords = explode('||', $value);
                        foreach ($subKeywords as $subKeyword) {
                            $subKeyword = trim($subKeyword);
                            $builder->where("d_material.inc LIKE '%$subKeyword%'");
                        }
                    } else {
                        // For OR condition
                        $keywords = explode('|', $value);
                        $builder->groupStart();
                        foreach ($keywords as $keyword) {
                            $builder->orLike('d_material.inc', trim($keyword));
                        }
                        $builder->groupEnd();
                    }
                    break;
                case 'searchMfr':
                    if (strpos($value, '||') !== false) {
                        $subKeywords = explode('||', $value);
                        foreach ($subKeywords as $subKeyword) {
                            $subKeyword = trim($subKeyword);
                            $builder->where("d_material.mfr LIKE '%$subKeyword%'");
                        }
                    } else {
                        // For OR condition
                        $keywords = explode('|', $value);
                        $builder->groupStart();
                        foreach ($keywords as $keyword) {
                            $builder->orLike('d_material.mfr', trim($keyword));
                        }
                        $builder->groupEnd();
                    }
                    break;
                case 'searchPartNumber':
                    if (strpos($value, '||') !== false) {
                        $subKeywords = explode('||', $value);
                        foreach ($subKeywords as $subKeyword) {
                            $subKeyword = trim($subKeyword);
                            $builder->where("d_material.part_number LIKE '%$subKeyword%'");
                        }
                    } else {
                        // For OR condition
                        $keywords = explode('|', $value);
                        $builder->groupStart();
                        foreach ($keywords as $keyword) {
                            $builder->orLike('d_material.part_number', trim($keyword));
                        }
                        $builder->groupEnd();
                    }
                    break;
                case 'searchAfter':
                    if (strpos($value, '||') !== false) {
                        $subKeywords = explode('||', $value);
                        foreach ($subKeywords as $subKeyword) {
                            $subKeyword = trim($subKeyword);
                            $builder->where("d_material.result LIKE '%$subKeyword%'");
                        }
                    } else {
                        // For OR condition
                        $keywords = explode('|', $value);
                        $builder->groupStart();
                        foreach ($keywords as $keyword) {
                            $builder->orLike('d_material.result', trim($keyword));
                        }
                        $builder->groupEnd();
                    }
                    break;
                case 'searchNumber':
                    if (strpos($value, '||') !== false) {
                        $subKeywords = explode('||', $value);
                        foreach ($subKeywords as $subKeyword) {
                            $subKeyword = trim($subKeyword);
                            $builder->where("d_material.material_number LIKE '%$subKeyword%'");
                        }
                    } else {
                        // For OR condition
                        $keywords = explode('|', $value);
                        $builder->groupStart();
                        foreach ($keywords as $keyword) {
                            $builder->orLike('d_material.material_number', trim($keyword));
                        }
                        $builder->groupEnd();
                    }
                    break;
                case 'searchFlag1':
                    if (strpos($value, '||') !== false) {
                        $subKeywords = explode('||', $value);
                        foreach ($subKeywords as $subKeyword) {
                            $subKeyword = trim($subKeyword);
                            $builder->where("d_material.flag1 LIKE '%$subKeyword%'");
                        }
                    } else {
                        // For OR condition
                        $keywords = explode('|', $value);
                        $builder->groupStart();
                        foreach ($keywords as $keyword) {
                            $builder->orLike('d_material.flag1', trim($keyword));
                        }
                        $builder->groupEnd();
                    }
                    break;
                case 'searchStatus':
                    if (strpos($value, '||') !== false) {
                        $subKeywords = explode('||', $value);
                        foreach ($subKeywords as $subKeyword) {
                            $subKeyword = trim($subKeyword);
                            $builder->where("d_material.status LIKE '%$subKeyword%'");
                        }
                    } else {
                        // For OR condition
                        $keywords = explode('|', $value);
                        $builder->groupStart();
                        foreach ($keywords as $keyword) {
                            $builder->orLike('d_material.status', trim($keyword));
                        }
                        $builder->groupEnd();
                    }
                    break;
                case 'searchBefore':
                    // Check if the search value contains || for AND condition
                    if (strpos($value, '||') !== false) {
                        $subKeywords = explode('||', $value);
                        foreach ($subKeywords as $subKeyword) {
                            $subKeyword = trim($subKeyword);
                            $builder->where("d_material.raw_data LIKE '%$subKeyword%'");
                        }
                    } else {
                        // For OR condition
                        $keywords = explode('|', $value);
                        $builder->groupStart();
                        foreach ($keywords as $keyword) {
                            $builder->orLike('d_material.raw_data', trim($keyword));
                        }
                        $builder->groupEnd();
                    }
                    break;
                case 'searchAll':
                    // Search in every column
                    $allowedFields = [
                        'inc',
                        'mfr',
                        'part_number',
                        'result',
                        'material_number',
                        'flag1',
                        'status',
                        'raw_data'
                    ];
                    $builder->groupStart();
                    foreach ($allowedFields as $field) {
                        $builder->orLike('d_material.' . $field, $value);
                    }
                    $builder->groupEnd();
                    break;
            }
        }
    }

    // Getting total count of results without pagination
    $totalResults = $builder->countAllResults(false);

    // Applying pagination and fetching data
    $builder->limit($perPage, $offset);

    $materials = $builder->get()->getResult();

    return ['materials' => $materials, 'totalResults' => $totalResults];
}




    public function updateINC($id, $inc)
    {
        $this->where('id', $id)->set(['inc' => $inc])->update();
    }

    public function updatecat($id, $cat)
    {
        $this->where('id', $id)->set(['cat' => $cat])->update();
    }

    public function updateQc($id, $qc)
    {
        $this->where('id', $id)->set(['qc' => $qc])->update();
    }
    public function updateStatus($id, $status)
    {
        $this->where('id', $id)->set(['status' => $status])->update();
    }

    // Assign / Update Cataloguer pada Material
    // public function updateCat($id, $newCat) {
    //     $data = ['cat' => $newCat];
    //     return $this->update($id, $data);
    // }
    
}