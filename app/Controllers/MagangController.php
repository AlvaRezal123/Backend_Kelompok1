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
        // Ambil data magang dengan relasi
        $magang = $this->magangModel->getMagangWithRelations();
    
        if (empty($magang)) {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'Data magang tidak ditemukan'
            ])->setStatusCode(404);
        }
    
        return $this->response->setJSON($magang);
    }

    public function show($id_magang)
    {
        // Ambil data magang spesifik dengan relasi
        $magang = $this->magangModel->getMagangWithRelations($id_magang);
    
        if (empty($magang)) {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'Data magang tidak ditemukan'
            ])->setStatusCode(404);
        }
    
        return $this->response->setJSON($magang[0]); // Karena hasil array, ambil index 0
    }
    

    // Perbaikan di MagangController CodeIgniter
public function store()
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

        // Bersihkan dan lowercase status_magang
        $data['status_magang'] = strtolower(trim($data['status_magang']));

        // Validasi status_magang hanya boleh "mbkm" atau "mandiri"
        if (!in_array($data['status_magang'], ['mbkm', 'mandiri'])) {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => "Status magang harus 'mbkm' atau 'mandiri'. Diterima: '" . $data['status_magang'] . "'"
            ])->setStatusCode(400);
        }

        // Debug: log data yang akan disimpan
        log_message('debug', 'Data magang yang akan disimpan: ' . json_encode($data));

        // Insert ke database
        $result = $this->magangModel->insert($data);
        
        if (!$result) {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'Gagal menambahkan data magang'
            ])->setStatusCode(500);
        }

        return $this->response->setJSON([
            'status' => 'success',
            'message' => 'Data magang berhasil ditambahkan',
            'id_magang' => $this->magangModel->getInsertID()
        ])->setStatusCode(201);
        
    } catch (\Exception $e) {
        log_message('error', 'Error store magang: ' . $e->getMessage());
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

            return $this->response->setJSON([
                'status' => 'success',
                'message' => 'Data magang berhasil diupdate'
            ])->setStatusCode(200);
            
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