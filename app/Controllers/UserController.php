<?php

namespace App\Controllers;

use CodeIgniter\RESTful\ResourceController;
use App\Models\User;
use PhpOffice\PhpSpreadsheet\IOFactory;

class UserController extends ResourceController
{
        protected $modelName = 'App\Models\User';

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

        $model = new User();
        $userData = $model->getAllUserData();
        // return $this->respond($data,200);

        if(!empty($userData)){
            $response = [
                'status' => 'success',
                'message' => 'Data User Berhasil Ditemukan',
                'data' => $userData
            ];
            return $this->respond($response,200);
        } else {
            $response = [
                'status' => 'error',
                'message' => 'Data User Tidak Ditemukan!!',
                'data' => []
            ];
            return $this->respond($response, 404);
        }
    }

    public function getCataloguer() {

        $model = new User();
        $userData = $model->getCatUser();
        // return $this->respond($data,200);

        if(!empty($userData)){
            $response = [
                'status' => 'success',
                'message' => 'Data Cataloguer Berhasil Ditemukan',
                'data' => $userData
            ];
            return $this->respond($response,200);
        } else {
            $response = [
                'status' => 'error',
                'message' => 'Data User Tidak Ditemukan!!',
                'data' => []
            ];
            return $this->respond($response, 404);
        }
    }
    
    public function getUserByRole($id) {
        $model = new User();
        $userData = $model->getUserByRole($id);
        // return $this->respond($data,200);

        if(!empty($userData)){
            $response = [
                'status' => 'success',
                'message' => 'Data Cataloguer Berhasil Ditemukan',
                'data' => $userData
            ];
            return $this->respond($response,200);
        } else {
            $response = [
                'status' => 'error',
                'message' => 'Data User Tidak Ditemukan!!',
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
            'name'      => 'required',
            'password'  => 'required',
            'role_id'   => 'required'
        ]);

        if (!$validation->withRequest($this->request)->run()) {
            $response = [
                'status'   => 400,
                'error'    => $validation->getErrors(),
                'messages' => [
                'error'    => 'Validasi data gagal. Mohon isi semua field dengan benar.'
                ]
            ];
            return $this->respond($response, 400);
        }

        $requestData = $this->request->getJSON();

        $model = new User();
        
        $name = 'name'; 
        $password = 'password'; 
        $role_id = 'role_id'; 

        $existingData = $model->where($name, $requestData->$name)->first();
        
        if ($existingData) {
            return $this->fail('Data dengan nama ini sudah ada di database.', 409); 
        } else {
            $hashedPassword = password_hash($requestData->$password, PASSWORD_DEFAULT);
            $model->insert([
                $name => $requestData->$name,
                $password => $hashedPassword,
                $role_id => $requestData->$role_id,
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
                    'name'  => $sheet->getCell('A' . $row)->getValue(),
                    'password'  => password_hash($sheet->getCell('B' . $row)->getValue(), PASSWORD_DEFAULT),
                    'role_id'  => $sheet->getCell('C' . $row)->getValue()
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
            'name'      => 'required',
            'password'  => 'required',
            'role_id'   => 'required'
        ]);

        if (!$validation->withRequest($this->request)->run()) {
            $response = [
                'status'   => 400,
                'error'    => $validation->getErrors(),
                'messages' => [
                'error'    => 'Validasi data gagal. Mohon isi semua field dengan benar.'
                ]
            ];
            return $this->respond($response, 400);
        }

        $name = $this->request->getVar('name');
        $password = $this->request->getVar('password');
        $role_id = $this->request->getVar('role_id');

        $model = new User();
        $data = [
            'name'      => $name,
            'password'  => $password,
            'role_id'   => $role_id,
        ];

        $model->update($id, $data);
        $response = [
            'status'   => 201,
            'error'    => null,
            'messages' => [
                'success' => 'Data User berhasil diubah.'
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

        $response = [
            'success' => 'Data User berhasil dihapus.'
        ];

        return $this->respondDeleted($response);
    }
}
