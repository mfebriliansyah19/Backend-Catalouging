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
        // var_dump($file->getExtension());

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
                // var_dump($sheet->getCell('material_number' . $row)->getValue());
                $rowData = [
                    'material_number'  => $sheet->getCell('A' . $row)->getValue(),
                    'part_number'  => $sheet->getCell('B' . $row)->getValue(),
                    'raw_data'  => $sheet->getCell('C' . $row)->getValue(),
                    'raw_data2'  => $sheet->getCell('D' . $row)->getValue(),
                    'raw_data3'  => $sheet->getCell('E' . $row)->getValue(),
                    'raw_data4'  => $sheet->getCell('F' . $row)->getValue(),
                    'flag1'  => $sheet->getCell('G' . $row)->getValue(),
                    'flag2'  => $sheet->getCell('H' . $row)->getValue(),
                    'result'  => $sheet->getCell('I' . $row)->getValue(),
                    'inc' => $sheet->getCell('J' . $row)->getValue(),
                    'mfr' => $sheet->getCell('K' . $row)->getValue(),
                    'group_code' => $sheet->getCell('L' . $row)->getValue(),
                    'cat' => $sheet->getCell('M' . $row)->getValue(),
                    'status' => $sheet->getCell('N' . $row)->getValue(),
                    'link' => $sheet->getCell('O' . $row)->getValue(),
                    // Sesuaikan dengan kolom di Excel dan tabel database
                ];
                var_dump($rowData);
                $dataToInsert[] = $rowData;
            }

            $this->model->insertBatch($dataToInsert);
            // $builder->insertBatch($dataToInsert);

            // Hapus file Excel dari server
            unlink($filePath);

            return "Bulk insert from Excel to database successful!";
        } else {
            return "Invalid file or file type. Please upload an Excel file (.xlsx).";
        }
    }

    public function updateINCByIDs()
    {
        $requestData = $this->request->getJSON();

        // Ambil INC dari data yang diterima
        $inc = $requestData->inc;

        // Ambil array IDs dari data yang diterima
        $IDs = $requestData->IDs;

        $model = new Material();
        foreach ($IDs as $id) {        
            $model->updateINC($id, $inc);
        }

        return $this->respond(['message' => 'Data updated with INC successfully'], 200);
    }

    public function updatecatByIDs()
    {
        $requestData = $this->request->getJSON();

        // Ambil INC dari data yang diterima
        $cat = $requestData->cat;

        // Ambil array IDs dari data yang diterima
        $IDs = $requestData->IDs;

        $model = new Material();
        foreach ($IDs as $id) {        
            $model->updatecat($id, $cat);
        }

        return $this->respond(['message' => 'Data updated with cat successfully'], 200);
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
