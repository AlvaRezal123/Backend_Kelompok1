<?php

namespace App\Controllers;

use CodeIgniter\HTTP\ResponseInterface;
use App\Models\Magang;

class MagangController extends BaseController
{
    protected $magangModel;

    public function __construct()
    {
        $this->magangModel = new Magang();
    }

    public function index()
    {
        $magang = $this->magangModel->findAll();
    
        if (empty($magang)) {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'Data magang tidak ditemukan'
            ])->setStatusCode(404);
        }
    
        return $this->response->setJSON($magang);
    }
    

    public function create()
    {
        try {
            $data = $this->request->getJSON(true);
    
            // Validasi input
            if (!isset($data['npm_mhs'], $data['id_perusahaan'], $data['nidn_pembimbing'], $data['tgl_mulai'], $data['tgl_selesai'], $data['status_magang'])) {
                return $this->response->setJSON([
                    'status' => 'error',
                    'message' => 'Semua field wajib diisi'
                ])->setStatusCode(400);
            }
    
            // Validasi status_magang hanya boleh "mbkm" atau "mandiri"
            if (!in_array($data['status_magang'], ['mbkm', 'mandiri'])) {
                return $this->response->setJSON([
                    'status' => 'error',
                    'message' => "Status magang harus 'mbkm' atau 'mandiri'"
                ])->setStatusCode(400);
            }
    
            // Generate ID Magang otomatis
            $data['id_magang'] = $this->magangModel->generateIdMagang();
    
            // Insert ke database
            $this->magangModel->insert($data);
    
            // Ambil data terbaru yang baru saja dimasukkan
            return $this->response->setJSON([
                'status' => 'success',
                'message' => 'Data magang berhasil ditambahkan'
            ])->setStatusCode(201);
            
    
        } catch (\Exception $e) {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => $e->getMessage()
            ])->setStatusCode(500);
        }
    }
    

public function update($id_magang)
{
    try {
        $data = $this->request->getJSON(true);

        // Cek apakah data magang dengan ID ini ada
        $existingData = $this->magangModel->find($id_magang);
        if (!$existingData) {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'Data magang tidak ditemukan'
            ])->setStatusCode(404);
        }

        // Validasi input (jangan sampai ada yang kosong)
        if (!isset($data['npm_mhs'], $data['id_perusahaan'], $data['nidn_pembimbing'], $data['tgl_mulai'], $data['tgl_selesai'], $data['status_magang'])) {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'Semua field wajib diisi'
            ])->setStatusCode(400);
        }

        // Validasi status_magang hanya boleh "mbkm" atau "mandiri"
        if (!in_array($data['status_magang'], ['mbkm', 'mandiri'])) {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => "Status magang harus 'mbkm' atau 'mandiri'"
            ])->setStatusCode(400);
        }

        // Update data di database
        $this->magangModel->update($id_magang, $data);

        // Ambil data terbaru setelah update
        return $this->response->setJSON([
            'status' => 'success',
            'message' => 'Data magang berhasil diupdate'
        ])->setStatusCode(201);
        

    } catch (\Exception $e) {
        return $this->response->setJSON([
            'status' => 'error',
            'message' => $e->getMessage()
        ])->setStatusCode(500);
    }
}

public function delete($id_magang)
{
    try {
        // Cek apakah data magang dengan ID ini ada
        $existingData = $this->magangModel->find($id_magang);
        if (!$existingData) {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'Data magang tidak ditemukan'
            ])->setStatusCode(404);
        }

        // Hapus data dari database
        $this->magangModel->delete($id_magang);

        return $this->response->setJSON([
            'status' => 'success',
            'message' => 'Data magang berhasil dihapus'
        ])->setStatusCode(200);

    } catch (\Exception $e) {
        return $this->response->setJSON([
            'status' => 'error',
            'message' => $e->getMessage()
        ])->setStatusCode(500);
    }
}




}
