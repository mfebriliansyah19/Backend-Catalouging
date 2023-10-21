<?php

namespace App\Controllers;

use CodeIgniter\RESTful\ResourceController;
use App\Models\Api;

class ApiController extends ResourceController
{

public function __construct()
{
    parent:: __construct();
    $this->load->model('Api');
}

public function login()
{

    if ($_SERVER["REQUEST METHOD"] == "POST"){
        if (isset($_POST['user']) && isset($_POST['pass'])) {

            $user_login = $this->Api->proses_login($_POST['user'], $_POST['pass']);
            $result['id'] = null;

            if ($user_login->num_rows()== 1){
                $result['value'] = "1";
                $result['pesan'] = "Sukses Login";
                $result['id'] = $user_login->row()->id;
            }else{
                $result['value'] = "0";
                $result['pesan'] = "Username/Password salah";
            }    
        }else{
            $result['value'] = "0";
            $result['pesan'] = "Beberapa inputan masi kosong";
        }
    }else {
        $result['value'] = "0";
        $result['pesan'] = "Invalid request";
    }
    echo json_encode($result);
    }
}

