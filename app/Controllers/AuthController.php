<?php

namespace App\Controllers;

use CodeIgniter\RESTful\ResourceController;
use App\Models\User;

class AuthController extends ResourceController
{

    protected $modelName = 'App\Models\User';

    public function login()
    {
        // Mengizinkan semua origin
        header("Access-Control-Allow-Origin: *");
        header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");
        header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

        // Validasi data masukan

        $requestData = (array) $this->request->getJSON();

        $validation = \Config\Services::validation();
        $validation->setRules([
            'name'      => 'required',
            'password'  => 'required'
        ]);

        if (!$validation->run($requestData)) {
            return $this->fail($validation->getErrors(), 400);
        }

        $model = new User();
        $name = $requestData['name'];
        $password = $requestData['password'];
        var_dump($name, $password);
        // $role_id = $this->request->getJSON('role_id');

        $user = $model->where('name', $name)->first();

        // if ($user  && password_verify($password, $user['password'])) {
        if ($user  && $password === $user['password']) {
            // $this->setToken($user['id']);
            return $this->respond(['message' => 'Login berhasil']);
        } else {
            return $this->fail('Username atau password salah', 401);
        }
    }

    public function logout()
    {
       return $this->respond(['message' => 'Logout berhasil']);
    }
}