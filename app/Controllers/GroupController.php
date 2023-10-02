<?php

namespace App\Controllers;

use CodeIgniter\RESTful\ResourceController;
use App\Models\GroupModel;

class GroupController extends ResourceController
{
    protected $modelName = 'App\Models\GroupModel';

    /**
     * Create a new group.
     *
     * @return mixed
     */
    public function create()
    {
        $validation = \Config\Services::validation();
        $validation->setRules([
            'group_code' => 'required',
            'group_name' => 'required'
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

        $groupCode = $this->request->getVar('group_code');
        $groupName = $this->request->getVar('group_name');

        $model = new GroupModel();
        $data = [
            'group_code' => $groupCode,
            'group_name' => $groupName,
        ];

        $model->insert($data);
        $response = [
            'status'   => 201,
            'error'    => null,
            'messages' => [
                'success' => 'Data produk berhasil ditambahkan.'
            ]
        ];
        return $this->respondCreated($response);
    }
}
