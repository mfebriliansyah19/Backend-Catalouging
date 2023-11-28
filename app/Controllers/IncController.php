<?php

namespace App\Controllers;

use CodeIgniter\RESTful\ResourceController;
use App\Models\Inc;
use PhpOffice\PhpSpreadsheet\IOFactory;

class IncController extends ResourceController
{
        protected $modelName = 'App\Models\Inc';

    /**
     * Return an array of resource objects, themselves in array format
     *
     * @return mixed
     */
    public function index()
    {
        header('Access-Control-Allow-Origin: *');
        header('Access-Control-Allow-Methods: GET, POST, DELETE');
        header("Access-Control-Allow-Headers: X-Requested-With");
        $model = new Inc();
        $incData = $model->getAllIncData();
        // return $this->respond($data,200);

        if(!empty($incData)){
            $response = [
                'status' => 'success',
                'message' => 'Data INC Berhasil Ditemukan',
                'data' => $incData
            ];
            return $this->respond($response,200);
        } else {
            $response = [
                'status' => 'error',
                'message' => 'Data INC Tidak Ditemukan!!',
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

    public function create()
    {
    //     $requestData = $this->request->getJSON();
    //     $validation = \Config\Services::validation();
    //     $validation->setRules([
    //         'INC'       => 'required',
    //         'INC_NAME'  => 'required'
    //     ]);

    //     if (!$validation->withRequest($this->request)->run()) {
    //         $response = [
    //             'status'   => 400,
    //             'error'    => $validation->getErrors(),
    //             'messages' => [
    //             'error'    => 'Validasi data gagal. Mohon isi semua field dengan benar.'
    //             ]
    //         ];
    //         return $this->respond($response, 400);
    //     }

    //     $INC = $this->request->getVar('INC');
    //     $INC_NAME = $this->request->getVar('INC_NAME');

    //     $model = new Inc();

    //    // Periksa apakah data sudah ada di dalam database
    //    $existingData = $model->where('INC', $requestData->INC)->first();
    //    $existingData = $model->where('INC_NAME', $requestData->INC_NAME)->first();

    //    if ($existingData) {
    //        // Jika data sudah ada, berikan respons bahwa data sudah ada
    //        return $this->fail('Data already exists in the database.', 409); // 409: Conflict
    //    } else {
    //        // Jika data belum ada, tambahkan ke dalam database
    //        $model->insert([
    //            'INC' => $requestData->$INC,
    //            'INC_NAME' => $requestData->$INC_NAME,
    //            // Tambahkan field lain sesuai kebutuhan
    //        ]);

    //        // Berikan respons sukses jika data berhasil ditambahkan
    //        return $this->respondCreated(['message' => 'Data added successfully']); // 201: Created
    //    }
 
    $requestData = $this->request->getJSON();

    $model = new Inc();

    $INC = 'INC'; 
    $INC_NAME = 'INC_NAME'; 

    $existingData = $model->where($INC, $requestData->$INC)->first();
    $existingData = $model->where($INC_NAME, $requestData->$INC_NAME)->first();

    if ($existingData) {
        return $this->fail('Data dengan nama ini sudah ada di database.', 409); // 409: Conflict
    } else {
        $model->insert([
            $INC => $requestData->$INC,
            $INC_NAME => $requestData->$INC_NAME,
        ]);

        return $this->respondCreated(['message' => 'Data berhasil di tambahkan']); // 201: Created
    }

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
                    'field1' => $sheet->getCell('INC' . $row)->getValue(),
                    'field2' => $sheet->getCell('INC_NAME' . $row)->getValue(),
                    // Sesuaikan dengan kolom di Excel dan tabel database
                ];

                $dataToInsert[] = $rowData;
            }

            // Lakukan bulk insert ke tabel database
            $db = \Config\Database::connect();
            $builder = $db->table('m_inc'); // Ganti dengan nama tabel yang sesuai

            $builder->insertBatch($dataToInsert);

            // Hapus file Excel dari server
            unlink($filePath);

            return "Bulk insert from Excel to database successful!";
        } else {
            return "Invalid file or file type. Please upload an Excel file (.xlsx).";
        }
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
            'INC'       => 'required',
            'INC_NAME'  => 'required'
        ]);

        if (!$validation->withRequest($this->request)->run()) {
            $response = [
                'status'   => 400,
                'error'    => $validation->getErrors(),
                'messages' => [
                'error'    => 'Validasi data gagal. Mohon isi semua field dengan benar.'
                ]
            ];
            return $this->respond($response, 400);
        }

        $INC = $this->request->getVar('INC');
        $INC_NAME = $this->request->getVar('INC_NAME');

        $model = new Inc();
        $data = [
            'INC' => $INC,
            'INC_NAME' => $INC_NAME,
        ];

        $model->update($id, $data);
        $response = [
            'status'   => 201,
            'error'    => null,
            'messages' => [
                'success' => 'Data INC berhasil diubah.'
            ]
        ];
        return $this->respond($response, 200);
    }

    /**
     * Delete the designated resource object from the model
     *
     * @return mixed
     */
    public function delete($id = null)
    {
        $this->model->delete($id);

        $response = [
            'success' => 'Data INC berhasil dihapus.'
        ];

        return $this->respondDeleted($response);
    }
}