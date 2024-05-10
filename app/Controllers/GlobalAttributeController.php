<?php

namespace App\Controllers;

use CodeIgniter\RESTful\ResourceController;
use App\Models\GlobalAttribute;
use PhpOffice\PhpSpreadsheet\IOFactory;

class GlobalAttributeController extends ResourceController
{
        protected $modelName = 'App\Models\GlobalAttribute';


    /**
     * Return an array of resource objects, themselves in array format
     *
     * @return mixed
     */
    public function index()
    {
        // Mengizinkan semua origin
        header("Access-Control-Allow-Origin: *");
        header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");
        header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

        
        $model = new GlobalAttribute();
        $GlobalAttributeData = $model->getAllGLobalAttributeData();
        // return $this->respond($data,200);

        if(!empty($GlobalAttributeData)){
            $response = [
                'status' => 'success',
                'message' => 'Data Global Attribute Berhasil Ditemukan',
                'data' => $GlobalAttributeData
            ];
            return $this->respond($response,200);
        } else {
            $response = [
                'status' => 'error',
                'message' => 'Data Global Attribute Tidak Ditemukan!!',
                'data' => []
            ];
            return $this->respond($response, 404);
        }
    }

    /**
     * Return the properties of a resource object
     *
     * @return mixed
     */
    public function show($id = null)
    {
        //
    }

    /**
     * Create a new resource object, from "posted" parameters
     *
     * @return mixed
     */
    public function create()
    {
        $validation = \Config\Services::validation();
        $validation->setRules([
            'attribute_code' => 'required',
            'attribute_name' => 'required',
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

        // $attribute_code = $this->request->getVar('attribute_code');
        // $attribute_name = $this->request->getVar('attribute_name');
        // // $created_at     = $this->request->getVar('created_at');
        // // $updated_at     = $this->request->getVar('update_at');

        // $model = new GlobalAttribute();

        // $data = [
        //     'attribute_code' => $attribute_code,
        //     'attribute_name' => $attribute_name,
        //     // 'created_at'     => $created_at,
        //     // 'updated_at'     => $updated_at,
        // ];

        // $model->insert($data);
        // $response = [
        //     'status'   => 201,
        //     'error'    => null,
        //     'messages' => [
        //         'success' => 'Data Global Attribute berhasil ditambahkan.'
        //     ]
        // ];
        // return $this->respondCreated($response);

        $requestData = $this->request->getJSON();

        $model = new GlobalAttribute();

        // Field yang ingin dicek tidak boleh sama
        $attribute_code = 'attribute_code'; 
        $attribute_name = 'attribute_name'; 

        $existingData = $model->where($attribute_code, $requestData->$attribute_code)->first();
        $existingData = $model->where($attribute_name, $requestData->$attribute_name)->first();

        if ($existingData) {
            return $this->fail('Data Dengan Nama ini sudah ada di database.', 409);
        } else {
            $model->insert([
                $attribute_code => $requestData->$attribute_code,
                $attribute_name => $requestData->$attribute_name,
            ]);

            return $this->respondCreated(['message' => 'Data berhasil ditambahkan']);
        }
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
                    'attribute_code'  => $sheet->getCell('A' . $row)->getValue(),
                    'attribute_name'  => $sheet->getCell('B' . $row)->getValue(),
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

    /**
     * Return the editable properties of a resource object
     *
     * @return mixed
     */
    public function edit($id = null)
    {
        //
    }

    /**
     * Add or update a model resource, from "posted" properties
     *
     * @return mixed
     */
    public function update($id = null)
    {
        $validation = \Config\Services::validation();
        $validation->setRules([
            'attribute_code' => 'required',
            'attribute_name' => 'required',
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

        $attribute_code = $this->request->getVar('attribute_code');
        $attribute_name = $this->request->getVar('attribute_name');

        $model = new GlobalAttribute();

        $data = [
            'attribute_code' => $attribute_code,
            'attribute_name' => $attribute_name
        ];

        $model->update($id, $data);
        $response = [
            'status'   => 201,
            'error'    => null,
            'messages' => [
            'success' => 'Data Global Attribute berhasil diubah.'
            ]
        ];
        return $this->respond($response, 200);
    }

    /**
     * Delete the designated resource object from the model
     *
     * @return mixed
     */
    public function delete($id = null)
    {
        $this->model->delete($id);
        // $model = new GlobalAttribute();
        // $model->delete($id);

        $response = [
            'success' => 'Data Global Attribute berhasil dihapus.'
        ];

        return $this->respondDeleted($response);
    }
}
