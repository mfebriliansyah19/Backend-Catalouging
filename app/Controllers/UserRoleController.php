<?php

namespace App\Controllers;

use CodeIgniter\RESTful\ResourceController;
use App\Models\UserRole;

class UserRoleController extends ResourceController
{
        // protected $modelName = 'App\Models\UserRole';

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

        $model = new UserRole();
        $userRole = $model->getAllUserRole();
        // return $this->respond($data,200);

        if(!empty($userRole)){
            $response = [
                'status' => 'success',
                'message' => 'Data Role Berhasil Ditemukan',
                'data' => $userRole
            ];
            return $this->respond($response,200);
        } else {
            $response = [
                'status' => 'error',
                'message' => 'Data Role Tidak Ditemukan!!',
                'data' => []
            ];
            return $this->respond($response, 404);
        }
    }
}
