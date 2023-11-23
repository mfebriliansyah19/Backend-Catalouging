<?php

namespace App\Controllers;

use CodeIgniter\RESTful\ResourceController;
use App\Models\Material;

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
        header('Access-Control-Allow-Origin: *');
        header('Access-Control-Allow-Methods: GET, POST, DELETE');
        header("Access-Control-Allow-Headers: X-Requested-With");
        $model = new Material();
        $materialData = $model->getAllMaterialData();

        if (!empty($materialData)) {
            $response = [
                'status' => 'success',
                'message' => 'Data Material Berhasil Ditemukan',
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
            'success' => 'Data Material berhasil ditambahkan.'
            ]
        ];
        return $this->respondCreated($response);
    }

    public function update($id = null)
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

        $model->update($id, $data);
        $response = [
            'status'   => 201,
            'error'    => null,
            'messages' => [
            'success' => 'Data Material berhasil diubah.'
            ]
        ];
        return $this->respondCreated($response);
    }

    // public function updateCat($id)
    // {
    //     try {
    //         $newCat = $this->request->getVar('newCat');
    //         $model = new Material();
    //         $result = $model->updateCat($id, $newCat);

    //         if ($result) {
    //             $response = [
    //                 'status' => 'success',
    //                 'message' => 'Cataloguer berhasil diupdate'
    //             ];
    //             return $this->respond($response, 200);
    //         } else {
    //             $response = [
    //                 'status' => 'error',
    //                 'message' => 'Gagal mengupdate cataloguer'
    //             ];
    //             return $this->respond($response, 400);
    //         }
    //     } catch (\Exception $e) {
    //         $response = [
    //             'status' => 'error',
    //             'message' => $e->getMessage()
    //         ];
    //         return $this->respond($response, 500);
    //     }
    // }

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
