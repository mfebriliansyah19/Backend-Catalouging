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
        header('Access-Control-Allow-Methods: GET, POST');
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
    public function updateCat($id)
    {
        try {
            $newCat = $this->request->getVar('newCat');
            $model = new Material();
            $result = $model->updateCat($id, $newCat);

            if ($result) {
                $response = [
                    'status' => 'success',
                    'message' => 'Cataloguer berhasil diupdate'
                ];
                return $this->respond($response, 200);
            } else {
                $response = [
                    'status' => 'error',
                    'message' => 'Gagal mengupdate cataloguer'
                ];
                return $this->respond($response, 400);
            }
        } catch (\Exception $e) {
            $response = [
                'status' => 'error',
                'message' => $e->getMessage()
            ];
            return $this->respond($response, 500);
        }
    }
}
