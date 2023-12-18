<?php

namespace App\Controllers;

use CodeIgniter\RESTful\ResourceController;
use App\Models\Attribute;
use PhpOffice\PhpSpreadsheet\IOFactory;

class AttributeController extends ResourceController
{
        protected $modelName = 'App\Models\Attribute';

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

        $model = new Attribute();
        $AttributeData = $model->getAllAttributeData();
        // return $this->respond($data,200);

        if(!empty($AttributeData)){
            $response = [
                'status' => 'success',
                'message' => 'Data Attribute Berhasil Ditemukan',
                'data' => $AttributeData
            ];
            return $this->respond($response,200);
        } else {
            $response = [
                'status' => 'error',
                'message' => 'Data Attribute Tidak Ditemukan!!',
                'data' => []
            ];
            return $this->respond($response, 404);
        }
    }

    /**
     * Return the properties of a resource object
     *
     * @return mixed
     */
    public function show($id = null)
    {
        //
    }

    /**
     * Create a new resource object, from "posted" parameters
     *
     * @return mixed
     */
    public function create()
    {
        $validation = \Config\Services::validation();
        $validation->setRules([
            'INC'                => 'required',
            'attribute_code'     => 'required',
            'attribute_name'     => 'required',
            'attribute_value'    => 'required'
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

        $INC                = $this->request->getVar('INC');
        $attribute_code     = $this->request->getVar('attribute_code');
        $attribute_name     = $this->request->getVar('attribute_name');
        $attribute_value    = $this->request->getVar('attribute_value');

        $model = new Attribute();

        $data = [
            'inc'               => $INC,
            'attribute_code'    => $attribute_code,
            'attribute_name'    => $attribute_name,
            'attribute_value'   => $attribute_value,
        ];

        $model->insert($data);
        $response = [
            'status'   => 201,
            'error'    => null,
            'messages' => [
            'success' => 'Data Attribute berhasil ditambahkan.'
            ]
        ];
        return $this->respondCreated($response);
    }

    /**
     * Return the editable properties of a resource object
     *
     * @return mixed
     */
    public function edit($id = null)
    {
        //
    }

    /**
     * Add or update a model resource, from "posted" properties
     *
     * @return mixed
     */
    public function update($id = null)
    {
        $validation = \Config\Services::validation();
        $validation->setRules([
            'INC'                => 'required',
            'attribute_code'     => 'required',
            'attribute_name'     => 'required',
            'attribute_value'    => 'required',
            'sequence'           => 'required'
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

        $INC                = $this->request->getVar('INC');
        $attribute_code     = $this->request->getVar('attribute_code');
        $attribute_name     = $this->request->getVar('attribute_name');
        $attribute_value    = $this->request->getVar('attribute_value');
        $sequence           = $this->request->getVar('sequence');

        $model = new Attribute();

        $data = [
            'inc'               => $INC,
            'attribute_code'    => $attribute_code,
            'attribute_name'    => $attribute_name,
            'attribute_value'   => $attribute_value,
            'sequence'          => $sequence,
        ];

        $model->update($id, $data);
        $response = [
            'status'   => 201,
            'error'    => null,
            'messages' => [
            'success' => 'Data Attribute berhasil diubah.'
            ]
        ];
        return $this->respond($response, 200);
    }

    public function bulkInsertFromExcel()
    {
        $file = $this->request->getFile('excel_file');

        if ($file !== null && $file->isValid() && $file->getExtension() === 'xlsx') {
            // Simpan file Excel ke server
            $file->move(WRITEPATH . 'uploads');

            // Path file Excel yang diunggah
            $filePath = WRITEPATH . 'uploads/' . $file->getName();

            // Load file Excel menggunakan PHPSpreadsheet
            $spreadsheet = IOFactory::load($filePath);
            $sheet = $spreadsheet->getActiveSheet();

            $dataToInsert = [];
            $highestRow = $sheet->getHighestRow();

            // Mulai dari baris kedua karena baris pertama mungkin berisi header
            for ($row = 2; $row <= $highestRow; $row++) {
                $rowData = [
                    'inc'  => $sheet->getCell('A' . $row)->getValue(),
                    'attribute_code'  => $sheet->getCell('B' . $row)->getValue(),
                    'attribute_name'  => $sheet->getCell('C' . $row)->getValue(),
                    'sequence'  => $sheet->getCell('D' . $row)->getValue(),
                ];
                
                $dataToInsert[] = $rowData;
            }
            // var_dump($rowData);
            $model = new Attribute();
            $model->insertBatch($dataToInsert);
            // Hapus file Excel dari server
            unlink($filePath);

            return "Bulk insert from Excel to database successful!";
        } else {
            return "Invalid file or file type. Please upload an Excel file (.xlsx).";
        }
    }

    public function delete($id = null)
    {
        // $this->model->delete($id);
        $model = new Attribute();
        $model->delete($id);

        $response = [
            'success' => 'Data Attribute berhasil dihapus.'
        ];

        return $this->respondDeleted($response);
    }
}
