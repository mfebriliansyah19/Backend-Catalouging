<?php

namespace App\Controllers;

use CodeIgniter\RESTful\ResourceController;
use App\Models\User;

class AuthController extends ResourceController
{

    protected $modelName = 'App\Models\User';

    public function login()
    {
        // Validasi data masukan
        $validation = \Config\Services::validation();
        $validation->setRules([
            'name'      => 'required',
            'password'  => 'required'
        ]);

        if (!$validation->run($this->request->getJSON())) {
            return $this->fail($validation->getErrors(), 400);
        }

        $model = new User();
        $name = $this->request->getJSON('name');
        $password = $this->request->getJSON('password');
        // $role_id = $this->request->getJSON('role_id');

        $user = $user->where('name', $user)->first();

        if ($user && password_verify($password, $user['password'])) {

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