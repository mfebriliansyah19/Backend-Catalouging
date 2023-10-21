<?php

namespace App\Models;

use CodeIgniter\Model;

class Api extends Model
{

public function proses_login($user, $pass){
    return $this->db->query("SELECT id FROM user WHERE username = $name AND password = $password = $password");
}

}