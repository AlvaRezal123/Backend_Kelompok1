<?php
namespace App\Controllers;

use CodeIgniter\HTTP\ResponseInterface;
use App\Models\Pembimbing;

class PembimbingController extends BaseController
{
    public function index()
    {
        $pembimbingModel = new Pembimbing();

        // Ambil semua data pembimbing dari tabel
        $pembimbing = $pembimbingModel->findAll();

       return $this->response->setJSON($pembimbing);

    }

    public function create()
    {
        return $this->store();
    }

    public function store()
    {
        $pembimbingModel = new Pembimbing();
        $data = $this->request->getJSON(true);
    
        // Validasi data input untuk pembimbing
        if (!$this->validate([
            'nidn_pembimbing'   => 'required|is_unique[pembimbing.nidn_pembimbing]',
            'nama_pembimbing'   => 'required',
            'email'             => 'required|valid_email',
            'no_telp'           => 'required|numeric'
        ])) {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'Validasi gagal',
                'errors' => $this->validator->getErrors()
            ])->setStatusCode(ResponseInterface::HTTP_BAD_REQUEST);
        }
    
        // Simpan data ke database
        $pembimbingModel->insert($data);
    
        return $this->response->setJSON([
            'status' => 'success',
            'message' => 'Data pembimbing berhasil ditambahkan'
        ])->setStatusCode(ResponseInterface::HTTP_CREATED);
        
    }

    public function update($id)
{
    $pembimbingModel = new Pembimbing();
    $data = $this->request->getJSON(true);

    // Cek apakah data pembimbing dengan ID (NIDN) tersebut ada
    $pembimbing = $pembimbingModel->find($id);
    if (!$pembimbing) {
        return $this->response->setJSON([
            'status' => 'error',
            'message' => 'Data pembimbing tidak ditemukan'
        ])->setStatusCode(ResponseInterface::HTTP_NOT_FOUND);
    }

    // Validasi data input
    if (!$this->validate([
        'nama_pembimbing' => 'required',
        'email'           => 'required|valid_email',
        'no_telp'         => 'required|numeric'
    ])) {
        return $this->response->setJSON([
            'status' => 'error',
            'message' => 'Validasi gagal',
            'errors' => $this->validator->getErrors()
        ])->setStatusCode(ResponseInterface::HTTP_BAD_REQUEST);
    }

    // Update data pembimbing
    $pembimbingModel->update($id, $data);

    return $this->response->setJSON([
        'status' => 'success',
        'message' => 'Data pembimbing berhasil diperbarui'
    ]);
    
}

public function delete($id)
{
    $pembimbingModel = new Pembimbing();

    // Cek apakah data pembimbing dengan ID tersebut ada
    $pembimbing = $pembimbingModel->find($id);

    if (!$pembimbing) {
        return $this->response->setJSON([
            'status' => 'error',
            'message' => 'Data pembimbing tidak ditemukan'
        ])->setStatusCode(ResponseInterface::HTTP_NOT_FOUND);
    }

    // Hapus data pembimbing
    $pembimbingModel->delete($id);

    return $this->response->setJSON([
        'status' => 'success',
        'message' => 'Data pembimbing berhasil dihapus'
    ])->setStatusCode(ResponseInterface::HTTP_OK);
}
    public function show($id)
    {
        $pembimbingModel = new Pembimbing();
        $pembimbing = $pembimbingModel->find($id);
        
        if (!$pembimbing) {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'Data pembimbing tidak ditemukan'
            ])->setStatusCode(ResponseInterface::HTTP_NOT_FOUND);
        }
        
        return $this->response->setJSON([
            'status' => 'success',
            'data' => $pembimbing
        ]);
    }
}