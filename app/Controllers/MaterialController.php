<?php

namespace App\Controllers;

use CodeIgniter\RESTful\ResourceController;
use App\Models\Material;
use PhpOffice\PhpSpreadsheet\IOFactory;

class MaterialController extends ResourceController
{
    protected $modelName = 'App\Models\Material';

    /**
     * Return an array of resource objects, themselves in array format
     *
     * @return mixed
     */
    
    public function index()
    {
        $model = new Material();
        $materialData = $model->getAllMaterialData();

        if (!empty($materialData)) {
            $response = [
                'status' => 'success',
                'message' => 'Data Material Telah Berhasil Ditemukan',
                'data' => $materialData
            ];
            return $this->respond($response, 200);
        } else {
            $response = [
                'status' => 'error',
                'message' => 'Data Material Tidak Ditemukan!!',
                'data' => []
            ];
            return $this->respond($response, 404);
        }
    }

    public function create()
    {

        $validation = \Config\Services::validation();
        $validation->setRules([
            'materialNumber' => 'required',
            'partNumber'     => 'required',
            'rawData'        => 'required',
            'rawData2'       => 'required',
            'rawData3'       => 'required',
            'rawData4'       => 'required',
            'flag1'          => 'required',
            'flag2'          => 'required',
            'result'         => 'required',
            'inc'            => 'required',
            'mfr'            => 'required',
            'groupCode'      => 'required',
            'cat'            => 'required',
            'status'         => 'required',
            'link'           => 'required'
        ]);

        if (!$validation->withRequest($this->request)->run()) {
            $response = [
                'status'   => 400,
                'error'    => $validation->getErrors(),
                'messages' => [
                'error' => 'Validasi data gagal. Mohon isi semua field dengan benar.'
                ]
            ];
            return $this->respond($response, 400);
        }

        $materialNumber = $this->request->getVar('materialNumber');
        $partNumber     = $this->request->getVar('partNumber');
        $rawData        = $this->request->getVar('rawData');
        $rawData2       = $this->request->getVar('rawData2');
        $rawData3       = $this->request->getVar('rawData3');
        $rawData4       = $this->request->getVar('rawData4');
        $flag1          = $this->request->getVar('flag1');
        $flag2          = $this->request->getVar('flag2');
        $result         = $this->request->getVar('result');
        $inc            = $this->request->getVar('inc');
        $mfr            = $this->request->getVar('mfr');
        $groupCode      = $this->request->getVar('groupCode');
        $cat            = $this->request->getVar('cat');
        $status         = $this->request->getVar('status');
        $link           = $this->request->getVar('link');

        $model = new Material();

        $data = [
        'materialNumber' =>   $materialNumber ,
        'partNumber' =>   $partNumber,
        'rawData'    =>   $rawData,
        'rawData2'   =>   $rawData2,
        'rawData3'   =>   $rawData3,
        'rawData4'   =>   $rawData4,
        'flag1'      =>   $flag1,
        'flag2'      =>   $flag2,
        'result'     =>   $result,
        'inc'        =>   $inc,
        'mfr'        =>   $mfr,
        'groupCode'  =>   $groupCode,
        'cat'        =>   $cat,
        'status'     =>   $status,
        'link'       =>   $link           
        ];

        $model->insert($data);
        $response = [
            'status'   => 201,
            'error'    => null,
            'messages' => [
            'success' => 'Data Material sukses ditambahkan.'
            ]
        ];
        return $this->respondCreated($response);
    }

    public function update($id = null)
    {

        $validation = \Config\Services::validation();
        $validation->setRules([
            'materialNumber' => 'required',
            // 'partNumber'     => 'required',
            // 'rawData'        => 'required',
            // 'rawData2'       => 'required',
            // 'rawData3'       => 'required',
            // 'rawData4'       => 'required',
            // 'flag1'          => 'required',
            // 'flag2'          => 'required',
            // 'result'         => 'required',
            // 'inc'            => 'required',
            // 'mfr'            => 'required',
            // 'groupCode'      => 'required',
            // 'cat'            => 'required',
            // 'status'         => 'required',
            // 'link'           => 'required'
        ]);

        if (!$validation->withRequest($this->request)->run()) {
            $response = [
                'status'   => 400,
                'error'    => $validation->getErrors(),
                'messages' => [
                'error' => 'Validasi data gagal. Mohon isi semua field dengan benar.'
                ]
            ];
            return $this->respond($response, 400);
        }

        $materialNumber         = $this->request->getVar('materialNumber');
        $partNumber             = $this->request->getVar('partNumber');
        $rawData                = $this->request->getVar('rawData');
        $rawData2               = $this->request->getVar('rawData2');
        $rawData3               = $this->request->getVar('rawData3');
        $rawData4               = $this->request->getVar('rawData4');
        $flag1                  = $this->request->getVar('flag1');
        $flag2                  = $this->request->getVar('flag2');
        $result                 = $this->request->getVar('result');
        $attributeValue         = $this->request->getVar('attribute_value');
        $globalAttributeValue   = $this->request->getVar('global_attribute_value');
        $inc                    = $this->request->getVar('inc');
        $mfr                    = $this->request->getVar('mfr');
        $groupCode              = $this->request->getVar('groupCode');
        $cat                    = $this->request->getVar('cat');
        $status                 = $this->request->getVar('status');
        $link                   = $this->request->getVar('link');

        $model = new Material();

        $data = [
        'material_number'           =>   $materialNumber ,
        'part_number'               =>   $partNumber,
        'raw_data'                  =>   $rawData,
        'raw_data2'                 =>   $rawData2,
        'raw_data3'                 =>   $rawData3,
        'raw_data4'                 =>   $rawData4,
        'flag1'                     =>   $flag1,
        'flag2'                     =>   $flag2,
        'result'                    =>   $result,
        'attribute_value'           =>   $attributeValue,
        'global_attribute_value'    =>   $globalAttributeValue,
        'inc'                       =>   $inc,
        'mfr'                       =>   $mfr,
        'group_code'                =>   $groupCode,
        'cat'                       =>   $cat,
        'status'                    =>   $status,
        'link'                      =>   $link           
        ];

        $model->update($id, $data);
        $response = [
            'status'   => 201,
            'messages' => [
            'success' => 'Data Material berhasil diubah.'
            ]
        ];
        return $this->respondCreated($response);
    }

    public function bulkInsertFromExcel()
    {
        $file = $this->request->getFile('excel_file');

        if ($file !== null && $file->isValid() && $file->getExtension() === 'xlsx') {
            // Simpan file Excel ke server
            $file->move(WRITEPATH . 'uploads');

            // Path file Excel yang diunggah
            $filePath = WRITEPATH . 'uploads/' . $file->getName();

            // Load file Excel menggunakan PHPSpreadsheet
            $spreadsheet = IOFactory::load($filePath);
            $sheet = $spreadsheet->getActiveSheet();

            $dataToInsert = [];
            $highestRow = $sheet->getHighestRow();

            // Mulai dari baris kedua karena baris pertama mungkin berisi header
            for ($row = 2; $row <= $highestRow; $row++) {
                // var_dump($sheet->getCell('material_number' . $row)->getValue());
                $rowData = [
                    'material_number'  => $sheet->getCell('A' . $row)->getValue(),
                    'raw_data'  => $sheet->getCell('B' . $row)->getValue(),
                    'raw_data2'  => $sheet->getCell('C' . $row)->getValue(),
                    'raw_data3'  => $sheet->getCell('D' . $row)->getValue(),
                    'raw_data4'  => $sheet->getCell('E' . $row)->getValue(),
                    'mfr' => $sheet->getCell('F' . $row)->getValue(),
                    'part_number'  => $sheet->getCell('G' . $row)->getValue(),
                ];
                
                $dataToInsert[] = $rowData;
            }

            $this->model->insertBatch($dataToInsert);
            // $builder->insertBatch($dataToInsert);

            // Hapus file Excel dari server
            unlink($filePath);

            return "Bulk insert from Excel to database successful!";
        } else {
            return "Invalid file or file type. Please upload an Excel file (.xlsx).";
        }
    }

    public function updateINCByIDs()
    {

        if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
            http_response_code(200);
            exit();
        }

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            http_response_code(405);
            exit();
        }


        $requestData = $this->request->getJSON();

        // Ambil INC dari data yang diterima
        $inc = $requestData->inc;

        // Ambil array IDs dari data yang diterima
        $IDs = $requestData->IDs;

        $model = new Material();
        foreach ($IDs as $id) {        
            $model->updateINC($id, $inc);
        }

        return $this->respond(['message' => 'Data updated with INC successfully'], 200);
    }

    public function updatecatByIDs()
    {
        $requestData = $this->request->getJSON();

        $cat = $requestData->cat;
        $IDs = $requestData->IDs;

        $model = new Material();
        foreach ($IDs as $id) {        
            $model->updatecat($id, $cat);
        }

        return $this->respond(['message' => 'Data updated with cat successfully'], 200);
    }

    public function updateQcByIDs()
    {
        $requestData = $this->request->getJSON();

 
        $qc = $requestData->qc;
        $IDs = $requestData->IDs;

        $model = new Material();
        foreach ($IDs as $id) {        
            $model->updateQc($id, $qc);
        }

        return $this->respond(['message' => 'Data updated with qc successfully'], 200);
    }

    public function updateStatusByIDs()
    {
        $requestData = $this->request->getJSON();

 
        $status = $requestData->status;
        $IDs = $requestData->IDs;

        $model = new Material();
        foreach ($IDs as $id) {        
            $model->updateStatus($id, $status);
        }

        return $this->respond(['message' => 'Data updated with status successfully'], 200);
    }

    public function delete($id = null)
    {
        $this->model->delete($id);
        // $model = new Material();
        // $model->delete($id);

        $response = [
            'success' => 'Data Material berhasil dihapus.'
        ];

        return $this->respondDeleted($response);
    }
}
