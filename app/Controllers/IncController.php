<?php

namespace App\Controllers;

use CodeIgniter\RESTful\ResourceController;
use App\Models\Inc;

class IncController extends ResourceController
{
        protected $modelName = 'App\Models\Inc';

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
        $model = new Inc();
        $incData = $model->getAllIncData();
        // return $this->respond($data,200);

        if(!empty($incData)){
            $response = [
                'status' => 'success',
                'message' => 'Data INC Berhasil Ditemukan',
                'data' => $incData
            ];
            return $this->respond($response,200);
        } else {
            $response = [
                'status' => 'error',
                'message' => 'Data INC Tidak Ditemukan!!',
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
        // $rules = $this->validate([
        //     'INC'       => 'required',
        //     'INC_Name'  => 'required',
        // ]);

        // if (!$rules) {
        //     $response = [
        //         'message' =>$this->validator->getErrors()
        //     ];

        //     return $this->failValidationError($response);
        // }

        $this->model->insert([
            'INC'       => esc($this->request->getVar('INC')),
            'INC_Name'  => esc($this->request->getVar('INC Name')),
        ]);
        $response=[
            'response' => 'Data INC Berhasil ditambahkan'
        ];

        return $this -> respondCreated($response);
        
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
