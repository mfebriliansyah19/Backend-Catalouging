<?php

namespace App\Controllers;

use CodeIgniter\RESTful\ResourceController;
use App\Models\User;
use \Firebase\JWT\JWT;


class AuthController extends ResourceController
{

    protected $modelName = 'App\Models\User';

    public function login()
    {

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
        // $role_id = $this->request->getJSON('role_id');

        // $user = $model->where('name', $name)->first();
        $user = $model->select('user.id, user.name, user.password, user.role_id, m_user_role.role_name')
            ->join('m_user_role', 'user.role_id = m_user_role.role_id', 'left')
            ->where('user.name', $name)
            ->first();

        if ($user  && password_verify($password, $user['password'])) {
            $secretKey = "cataloguer_secret_key_2023";
            $payload = array(
                'user_id' => $user['id'],
                'username' => $user['name'],
                'role_id' => $user['role_id'],
                'role_name' => $user['role_name']
            );

            // Buat token JWT
            $token = JWT::encode($payload, $secretKey, 'HS256');

            // Kirim token sebagai respons
            return $this->respond(['token' => $token, 'message' => 'Login berhasil']);
        } else {
            return $this->fail('Username atau password salah', 401);
        }
    }

    public function logout()
    {
       return $this->respond(['message' => 'Logout berhasil']);
    }
}