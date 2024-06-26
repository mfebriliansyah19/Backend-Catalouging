<?php

namespace App\Controllers;

use CodeIgniter\RESTful\ResourceController;
use App\Models\GroupModel;
use PhpOffice\PhpSpreadsheet\IOFactory;

class GroupController extends ResourceController
{
    protected $modelName = 'App\Models\GroupModel';

    /**
     * Create a new group.
     *
     * @return mixed
     */
    public function index()
    {
        // Mengizinkan semua origin
        header("Access-Control-Allow-Origin: *");
        header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");
        header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

        $model = new GroupModel();
        $groupData = $model->getAllGroupData();
        // return $this->respond($data,200);

        if(!empty($groupData)){
            $response = [
                'status' => 'success',
                'message' => 'Data Group Berhasil Ditemukan',
                'data' => $groupData
            ];
            return $this->respond($response,200);
        } else {
            $response = [
                'status' => 'error',
                'message' => 'Data Group Tidak Ditemukan!!',
                'data' => []
            ];
            return $this->respond($response, 404);
        }
    }

    public function create()
    {
        // $validation = \Config\Services::validation();
        // $validation->setRules([
        //     'group_code' => 'required',
        //     'group_name' => 'required'
        // ]);

        // if (!$validation->withRequest($this->request)->run()) {
        //     $response = [
        //         'status'   => 400,
        //         'error'    => $validation->getErrors(),
        //         'messages' => [
        //             'error' => 'Validasi data gagal. Mohon isi semua field dengan benar.'
        //         ]
        //     ];
        //     return $this->respond($response, 400);
        // }

        // $groupCode = $this->request->getVar('group_code');
        // $groupName = $this->request->getVar('group_name');

        // $model = new GroupModel();
        // $data = [
        //     'group_code' => $groupCode,
        //     'group_name' => $groupName,
        // ];

        // $model->insert($data);
        // $response = [
        //     'status'   => 201,
        //     'error'    => null,
        //     'messages' => [
        //         'success' => 'Data Group berhasil ditambahkan.'
        //     ]
        // ];
        // return $this->respondCreated($response);

        $requestData = $this->request->getJSON();

        $model = new GroupModel();

        $groupCode = 'group_code'; 
        $groupName = 'group_name'; 

        $existingData = $model->where($groupCode, $requestData->$groupCode)->first();
        $existingData = $model->where($groupName, $requestData->$groupName)->first();

        if ($existingData) {
            return $this->fail('Data Dengan Nama ini sudah ada di database.', 409);
        } else {
            $model->insert([
                $groupCode => $requestData->$groupCode,
                $groupName => $requestData->$groupName,
            ]);

            return $this->respondCreated(['message' => 'Data Berhasil Ditambahkan']);
        }
    }

    public function update($id = null)
    {
        $validation = \Config\Services::validation();
        $validation->setRules([
            'group_code' => 'required',
            'group_name' => 'required'
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

        $groupCode = $this->request->getVar('group_code');
        $groupName = $this->request->getVar('group_name');

        $model = new GroupModel();
        $data = [
            'group_code' => $groupCode,
            'group_name' => $groupName,
        ];

        $model->update($id, $data);
        $response = [
            'status'   => 201,
            'error'    => null,
            'messages' => [
                'success' => 'Data Group berhasil diubah.'
            ]
        ];
        return $this->respond($response, 200);
    }
    
    public function bulkInsertFromExcel()
    {
        // header("Access-Control-Allow-Origin: *");
        // header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");
        // header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

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
                    'group_code'  => $sheet->getCell('A' . $row)->getValue(),
                    'group_name'  => $sheet->getCell('B' . $row)->getValue(),
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

    public function delete($id = null)
    {
        $this->model->delete($id);

        $response = [
            'success' => 'Data Group berhasil dihapus.'
        ];

        return $this->respondDeleted($response);
    }
}