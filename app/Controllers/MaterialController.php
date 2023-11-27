<?php

namespace App\Controllers;

use CodeIgniter\RESTful\ResourceController;
use App\Models\Material;
use PhpOffice\PhpSpreadsheet\IOFactory;

class MaterialController extends ResourceController
{
    protected $modelName = 'App\Models\Material';

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
        $model = new Material();
        $materialData = $model->getAllMaterialData();

        if (!empty($materialData)) {
            $response = [
                'status' => 'success',
                'message' => 'Data Material Berhasil Ditemukan',
                'data' => $materialData
            ];
            return $this->respond($response, 200);
        } else {
            $response = [
                'status' => 'error',
                'message' => 'Data Material Tidak Ditemukan!!',
                'data' => []
            ];
            return $this->respond($response, 404);
        }
    }

    public function create()
    {
        $validation = \Config\Services::validation();
        $validation->setRules([
            'materialNumber' => 'required',
            'partNumber'     => 'required',
            'rawData'        => 'required',
            'rawData2'       => 'required',
            'rawData3'       => 'required',
            'rawData4'       => 'required',
            'flag1'          => 'required',
            'flag2'          => 'required',
            'result'         => 'required',
            'inc'            => 'required',
            'mfr'            => 'required',
            'groupCode'      => 'required',
            'cat'            => 'required',
            'status'         => 'required',
            'link'           => 'required'
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

        $materialNumber = $this->request->getVar('materialNumber');
        $partNumber     = $this->request->getVar('partNumber');
        $rawData        = $this->request->getVar('rawData');
        $rawData2       = $this->request->getVar('rawData2');
        $rawData3       = $this->request->getVar('rawData3');
        $rawData4       = $this->request->getVar('rawData4');
        $flag1          = $this->request->getVar('flag1');
        $flag2          = $this->request->getVar('flag2');
        $result         = $this->request->getVar('result');
        $inc            = $this->request->getVar('inc');
        $mfr            = $this->request->getVar('mfr');
        $groupCode      = $this->request->getVar('groupCode');
        $cat            = $this->request->getVar('cat');
        $status         = $this->request->getVar('status');
        $link           = $this->request->getVar('link');

        $model = new Material();

        $data = [
        'materialNumber' =>   $materialNumber ,
        'partNumber' =>   $partNumber,
        'rawData'    =>   $rawData,
        'rawData2'   =>   $rawData2,
        'rawData3'   =>   $rawData3,
        'rawData4'   =>   $rawData4,
        'flag1'      =>   $flag1,
        'flag2'      =>   $flag2,
        'result'     =>   $result,
        'inc'        =>   $inc,
        'mfr'        =>   $mfr,
        'groupCode'  =>   $groupCode,
        'cat'        =>   $cat,
        'status'     =>   $status,
        'link'       =>   $link           
        ];

        $model->insert($data);
        $response = [
            'status'   => 201,
            'error'    => null,
            'messages' => [
            'success' => 'Data Material berhasil ditambahkan.'
            ]
        ];
        return $this->respondCreated($response);
    }

    public function update($id = null)
    {
        $validation = \Config\Services::validation();
        $validation->setRules([
            'materialNumber' => 'required',
            'partNumber'     => 'required',
            'rawData'        => 'required',
            'rawData2'       => 'required',
            'rawData3'       => 'required',
            'rawData4'       => 'required',
            'flag1'          => 'required',
            'flag2'          => 'required',
            'result'         => 'required',
            'inc'            => 'required',
            'mfr'            => 'required',
            'groupCode'      => 'required',
            'cat'            => 'required',
            'status'         => 'required',
            'link'           => 'required'
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

        $materialNumber = $this->request->getVar('materialNumber');
        $partNumber     = $this->request->getVar('partNumber');
        $rawData        = $this->request->getVar('rawData');
        $rawData2       = $this->request->getVar('rawData2');
        $rawData3       = $this->request->getVar('rawData3');
        $rawData4       = $this->request->getVar('rawData4');
        $flag1          = $this->request->getVar('flag1');
        $flag2          = $this->request->getVar('flag2');
        $result         = $this->request->getVar('result');
        $inc            = $this->request->getVar('inc');
        $mfr            = $this->request->getVar('mfr');
        $groupCode      = $this->request->getVar('groupCode');
        $cat            = $this->request->getVar('cat');
        $status         = $this->request->getVar('status');
        $link           = $this->request->getVar('link');

        $model = new Material();

        $data = [
        'materialNumber' =>   $materialNumber ,
        'partNumber' =>   $partNumber,
        'rawData'    =>   $rawData,
        'rawData2'   =>   $rawData2,
        'rawData3'   =>   $rawData3,
        'rawData4'   =>   $rawData4,
        'flag1'      =>   $flag1,
        'flag2'      =>   $flag2,
        'result'     =>   $result,
        'inc'        =>   $inc,
        'mfr'        =>   $mfr,
        'groupCode'  =>   $groupCode,
        'cat'        =>   $cat,
        'status'     =>   $status,
        'link'       =>   $link           
        ];

        $model->update($id, $data);
        $response = [
            'status'   => 201,
            'error'    => null,
            'messages' => [
            'success' => 'Data Material berhasil diubah.'
            ]
        ];
        return $this->respondCreated($response);
    }

    // public function updateCat($id)
    // {
    //     try {
    //         $newCat = $this->request->getVar('newCat');
    //         $model = new Material();
    //         $result = $model->updateCat($id, $newCat);

    //         if ($result) {
    //             $response = [
    //                 'status' => 'success',
    //                 'message' => 'Cataloguer berhasil diupdate'
    //             ];
    //             return $this->respond($response, 200);
    //         } else {
    //             $response = [
    //                 'status' => 'error',
    //                 'message' => 'Gagal mengupdate cataloguer'
    //             ];
    //             return $this->respond($response, 400);
    //         }
    //     } catch (\Exception $e) {
    //         $response = [
    //             'status' => 'error',
    //             'message' => $e->getMessage()
    //         ];
    //         return $this->respond($response, 500);
    //     }
    // }

    public function bulkInsertFromExcel()
    {
        $file = $this->request->getFile('excel_file');

        if ($file !== null && $file->isValid() && $file->getExtension() === '.xlsx') {
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
                    'field1'  => $sheet->getCell('material_number' . $row)->getValue(),
                    'field2'  => $sheet->getCell('part_number' . $row)->getValue(),
                    'field3'  => $sheet->getCell('raw_data' . $row)->getValue(),
                    'field4'  => $sheet->getCell('raw_data2' . $row)->getValue(),
                    'field5'  => $sheet->getCell('raw_data3' . $row)->getValue(),
                    'field6'  => $sheet->getCell('raw_data4' . $row)->getValue(),
                    'field7'  => $sheet->getCell('flag1' . $row)->getValue(),
                    'field8'  => $sheet->getCell('flag2' . $row)->getValue(),
                    'field9'  => $sheet->getCell('result' . $row)->getValue(),
                    'field10' => $sheet->getCell('inc' . $row)->getValue(),
                    'field11' => $sheet->getCell('mfr' . $row)->getValue(),
                    'field12' => $sheet->getCell('group_code' . $row)->getValue(),
                    'field13' => $sheet->getCell('cat' . $row)->getValue(),
                    'field14' => $sheet->getCell('status' . $row)->getValue(),
                    'field15' => $sheet->getCell('link' . $row)->getValue(),
                    // Sesuaikan dengan kolom di Excel dan tabel database
                ];

                $dataToInsert[] = $rowData;
            }

            // Lakukan bulk insert ke tabel database
            $db = \Config\Database::connect();
            $builder = $db->table('d_material'); // Ganti dengan nama tabel yang sesuai

            $builder->insertBatch($dataToInsert);

            // Hapus file Excel dari server
            unlink($filePath);

            return "Bulk insert from Excel to database successful!";
        } else {
            return "Invalid file or file type. Please upload an Excel file (.xlsx).";
        }
    }

    public function delete($id = null)
    {
        $this->model->delete($id);
        // $model = new Material();
        // $model->delete($id);

        $response = [
            'success' => 'Data Material berhasil dihapus.'
        ];

        return $this->respondDeleted($response);
    }
}
