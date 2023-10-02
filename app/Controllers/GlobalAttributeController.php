<?php

namespace App\Controllers;

use CodeIgniter\RESTful\ResourceController;
use App\Models\Attribute;

class GlobalAttributeController extends ResourceController
{
        protected $modelName = 'App\Models\GlobalAttribute
    ';

    /**
     * Return an array of resource objects, themselves in array format
     *
     * @return mixed
     */
    public function index()
    {
        header('Access-Control-Allow-Origin: *');
        header('Access-Control-Allow-Methods: GET, POST');
        header("Access-Control-Allow-Headers: X-Requested-With");
        $model = new Attribute
    ();
        $GlobalAttributeData = $model->getAllGLobalAttributeData();
        // return $this->respond($data,200);

        if(!empty($GlobalAttributeData)){
            $response = [
                'status' => 'success',
                'message' => 'Data Attribute Berhasil Ditemukan',
                'data' => $AttributeData
            ];
            return $this->respond($response,200);
        } else {
            $response = [
                'status' => 'error',
                'message' => 'Data Attribute Tidak Ditemukan!!',
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
            'Attribute' => 'required',
            'Attribute_Name' => 'required'
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

        $Attribute = $this->request->getVar('Attribute');
        $INCName = $this->request->getVar('Attribute_Name');

        $model = new Attribute
    ();
        $data = [
            'inc' => $Attribute,
            'Attribute_Name' => $INCName,
        ];

        $model->insert($data);
        $response = [
            'status'   => 201,
            'error'    => null,
            'messages' => [
                'success' => 'Data produk berhasil ditambahkan.'
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
        //
    }

    /**
     * Delete the designated resource object from the model
     *
     * @return mixed
     */
    public function delete($id = null)
    {
        //
    }
}
