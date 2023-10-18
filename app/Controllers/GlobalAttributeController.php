<?php

namespace App\Controllers;

use CodeIgniter\RESTful\ResourceController;
use App\Models\GlobalAttribute;

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
        header('Access-Control-Allow-Origin: *');
        header('Access-Control-Allow-Methods: GET, POST, DELETE');
        header("Access-Control-Allow-Headers: X-Requested-With");
        
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

        $attribute_code = $this->request->getVar('attribute_code');
        $attribute_name = $this->request->getVar('attribute_name');
        // $created_at     = $this->request->getVar('created_at');
        // $updated_at     = $this->request->getVar('update_at');

        $model = new GlobalAttribute();

        $data = [
            'attribute_code' => $attribute_code,
            'attribute_name' => $attribute_name,
            // 'created_at'     => $created_at,
            // 'updated_at'     => $updated_at,
        ];

        $model->insert($data);
        $response = [
            'status'   => 201,
            'error'    => null,
            'messages' => [
                'success' => 'Data Global Attribute berhasil ditambahkan.'
            ]
        ];
        return $this->respondCreated($response);
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
