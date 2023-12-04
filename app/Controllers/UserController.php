<?php

namespace App\Controllers;

use CodeIgniter\RESTful\ResourceController;
use App\Models\User;

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
        // Mengizinkan semua origin
        header("Access-Control-Allow-Origin: *");
        header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");
        header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

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

        // $name = $this->request->getVar('name');
        // $password = $this->request->getVar('password');
        // $role_id = $this->request->getVar('role_id');

        // $model = new User();
        // $data = [
        //     'name'      => $name,
        //     'password'  => $password,
        //     'role_id'   => $role_id,
        // ];

        // $model->insert($data);
        // $response = [
        //     'status'   => 201,
        //     'error'    => null,
        //     'messages' => [
        //         'success' => 'Data User berhasil ditambahkan.'
        //     ]
        // ];
        // return $this->respondCreated($response);

        $requestData = $this->request->getJSON();

        $model = new User();
        
        $name = 'name'; 
        $password = 'password'; 
        $role_id = 'role_id'; 

        $existingData = $model->where($name, $requestData->$name)->first();
        
        if ($existingData) {
            return $this->fail('Data dengan nama ini sudah ada di database.', 409); 
        } else {
            $model->insert([
                $name => $requestData->$name,
                $password => $requestData->$password,
                $role_id => $requestData->$role_id,
            ]);

            return $this->respondCreated(['message' => 'Data berhasil ditambahkan']); // 201: Created
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
