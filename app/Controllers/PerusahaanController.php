<?php

namespace App\Controllers;

use CodeIgniter\HTTP\ResponseInterface;
use App\Models\Perusahaan;

class PerusahaanController extends BaseController
{
    public function index()
    {
        $perusahaanModel = new Perusahaan();
        $perusahaan = $perusahaanModel->findAll();
    
        if (!$perusahaan) {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'Tidak ada data perusahaan'
            ])->setStatusCode(ResponseInterface::HTTP_NOT_FOUND);
        }
    
        // Langsung tampilkan data tanpa harus klik "perusahaan"
        return $this->response->setJSON($perusahaan);
    }
    

    public function create()
    {
        return $this->store();
    }

    public function store()
    {
        $perusahaanModel = new Perusahaan();
        $data = $this->request->getJSON(true);

        // Validasi data input
        if (!$this->validate([
            'nama_perusahaan'  => 'required',
            'no_telp'          => 'required|regex_match[/^[0-9]+$/]', // Hanya angka
            'alamat'           => 'required',
            'email_perusahaan' => 'required|valid_email'
        ])) {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'Validasi gagal',
                'errors' => $this->validator->getErrors()
            ])->setStatusCode(ResponseInterface::HTTP_BAD_REQUEST);
        }

        // Simpan data ke database
        $perusahaanModel->insert($data);
        $insertedId = $perusahaanModel->insertID();
        $newData = $perusahaanModel->find($insertedId);

        return $this->response->setJSON([
            'status' => 'success',
            'message' => 'Data perusahaan berhasil ditambahkan'
        ])->setStatusCode(ResponseInterface::HTTP_CREATED);
        
    }

    public function show($id)
    {
        $perusahaanModel = new Perusahaan();
        $perusahaan = $perusahaanModel->find($id);

        if (!$perusahaan) {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'Data perusahaan tidak ditemukan'
            ])->setStatusCode(ResponseInterface::HTTP_NOT_FOUND);
        }

        return $this->response->setJSON(array_merge([
            'status' => 'success',
            'message' => 'Data perusahaan berhasil diambil'
        ], $perusahaan));
    }

    public function update($id)
    {
        $perusahaanModel = new Perusahaan();
        $data = $this->request->getJSON(true);

        // Cek apakah data perusahaan dengan ID tersebut ada
        $perusahaan = $perusahaanModel->find($id);
        if (!$perusahaan) {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'Data perusahaan tidak ditemukan'
            ])->setStatusCode(ResponseInterface::HTTP_NOT_FOUND);
        }

        // Validasi data input
        if (!$this->validate([
            'nama_perusahaan'  => 'required',
            'no_telp'          => 'required|regex_match[/^[0-9]+$/]', // Hanya angka
            'alamat'           => 'required',
            'email_perusahaan' => 'required|valid_email'
        ])) {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'Validasi gagal',
                'errors' => $this->validator->getErrors()
            ])->setStatusCode(ResponseInterface::HTTP_BAD_REQUEST);
        }

        // Update data perusahaan
        $perusahaanModel->update($id, $data);
        $updatedData = $perusahaanModel->find($id);

        return $this->response->setJSON([
            'status' => 'success',
            'message' => 'Data perusahaan berhasil diperbarui'
        ]);
        
    }

    public function delete($id)
    {
        $perusahaanModel = new Perusahaan();

        // Cek apakah data perusahaan dengan ID tersebut ada
        $perusahaan = $perusahaanModel->find($id);

        if (!$perusahaan) {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'Data perusahaan tidak ditemukan'
            ])->setStatusCode(ResponseInterface::HTTP_NOT_FOUND);
        }

        // Hapus data perusahaan
        $perusahaanModel->delete($id);

        return $this->response->setJSON([
            'status' => 'success',
            'message' => 'Data perusahaan berhasil dihapus'
        ])->setStatusCode(ResponseInterface::HTTP_OK);
    }
}
