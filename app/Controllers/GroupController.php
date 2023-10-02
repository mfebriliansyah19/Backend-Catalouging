<?php

namespace App\Controllers;

use CodeIgniter\RESTful\ResourceController;
use CodeIgniter\API\ResponseTrait;
use App\Models\GroupModel;

class GroupController extends ResourceController
{
    protected $modelName = 'App\Models\GroupModel';

    /**
     * Return an array of resource objects, themselves in array format
     *
     * @return mixed
     */
    public function create()
    {
        // Validasi data yang diterima dari permintaan POST
        $validation = \Config\Services::validation();
        $validation->setRules([
            'group_code' => 'required',
            'group_name' => 'required'
        ]);

        if (!$validation->withRequest($this->request)->run()) {
            return $this->fail($validation->getErrors());
        }

        // Ambil data dari permintaan POST
        $groupCode = $this->request->getPost('group_code');
        $groupName = $this->request->getPost('group_name');

        // Simpan data ke dalam tabel "group"
        $model = new GroupModel();
        $data = [
            'group_code' => $groupCode,
            'group_name' => $groupName
        ];

        if ($model->insert($data)) {
            return $this->respondCreated(['message' => 'Data grup berhasil ditambahkan']);
        } else {
            return $this->fail('Gagal menambahkan data grup');
        }
    }
}
