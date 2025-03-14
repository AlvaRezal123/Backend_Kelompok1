<?php

namespace App\Controllers;

use CodeIgniter\HTTP\ResponseInterface;
use App\Models\Mahasiswa;

class MahasiswaController extends BaseController
{
    public function index()
{
    $mahasiswaModel = new Mahasiswa();

    // Ambil semua data mahasiswa dari tabel
    $mahasiswa = $mahasiswaModel->findAll();

    if (empty($mahasiswa)) {
        return $this->response->setJSON([
            'status' => 'error',
            'message' => 'Data mahasiswa tidak ditemukan'
        ])->setStatusCode(404);
    }

    return $this->response->setJSON($mahasiswa);
}
    

    public function create()
    {
        return $this->store();
    }

   public function store()
{
    $mahasiswaModel = new Mahasiswa();
    $data = $this->request->getJSON(true);

    // Daftar program studi yang diperbolehkan
    $allowedProdi = [
        "Teknik Informatika", "Teknik Mesin", "Teknik Elektronika", "Teknik Listrik",
        "Teknik Pencemaran Pengendalian Lingkungan", "Teknik Rekayasa Keamanan Cyber",
        "Teknik Rekayasa Multimedia", "Akutansi Keuangan Lembaga Syariah",
        "Teknik Rekayasa Perangkat Lunak", "Teknik Rekayasa Kimia Industri",
        "Teknik Rekayasa Mekatronika", "Pengembangan Produk Argoindustri",
        "Teknik Rekayasa Energi Terbarukan"
    ];

    // Validasi data input
    if (!$this->validate([
        'npm_mhs'   => 'required|is_unique[mahasiswa.npm_mhs]',
        'nama_mhs'  => 'required',
        'prodi'     => 'required|in_list[' . implode(',', $allowedProdi) . ']',
        'alamat'    => 'required',
        'no_telp'   => 'required|numeric',
        'email'     => 'required|valid_email'
    ])) {
        return $this->response->setJSON([
            'status' => 'error',
            'message' => 'Validasi gagal',
            'errors' => $this->validator->getErrors()
        ])->setStatusCode(ResponseInterface::HTTP_BAD_REQUEST);
    }

    // Simpan data ke database
    $mahasiswaModel->insert($data);

    return $this->response->setJSON([
        'status' => 'success',
        'message' => 'Data mahasiswa berhasil ditambahkan'
    ])->setStatusCode(ResponseInterface::HTTP_CREATED);
    
}

public function update($id)
{
    $mahasiswaModel = new Mahasiswa();
    $data = $this->request->getJSON(true);

    // Cek apakah data mahasiswa dengan ID tersebut ada
    $mahasiswa = $mahasiswaModel->find($id);
    if (!$mahasiswa) {
        return $this->response->setJSON([
            'status' => 'error',
            'message' => 'Data mahasiswa tidak ditemukan'
        ])->setStatusCode(ResponseInterface::HTTP_NOT_FOUND);
    }

    // Daftar program studi yang diperbolehkan
    $allowedProdi = [
        "Teknik Informatika", "Teknik Mesin", "Teknik Elektronika", "Teknik Listrik",
        "Teknik Pencemaran Pengendalian Lingkungan", "Teknik Rekayasa Keamanan Cyber",
        "Teknik Rekayasa Multimedia", "Akutansi Keuangan Lembaga Syariah",
        "Teknik Rekayasa Perangkat Lunak", "Teknik Rekayasa Kimia Industri",
        "Teknik Rekayasa Mekatronika", "Pengembangan Produk Argoindustri",
        "Teknik Rekayasa Energi Terbarukan"
    ];

    // Validasi data input
    if (!$this->validate([
        'nama_mhs'  => 'required',
        'prodi'     => 'required|in_list[' . implode(',', $allowedProdi) . ']',
        'alamat'    => 'required',
        'no_telp'   => 'required|numeric',
        'email'     => 'required|valid_email'
    ])) {
        return $this->response->setJSON([
            'status' => 'error',
            'message' => 'Validasi gagal',
            'errors' => $this->validator->getErrors()
        ])->setStatusCode(ResponseInterface::HTTP_BAD_REQUEST);
    }

    // Update data mahasiswa
    $mahasiswaModel->update($id, $data);

    return $this->response->setJSON([
        'status' => 'success',
        'message' => 'Data mahasiswa berhasil diperbarui'
    ]);
    
}

    public function delete($id)
{
    $mahasiswaModel = new Mahasiswa();

    // Cek apakah data dengan ID tersebut ada
    $mahasiswa = $mahasiswaModel->find($id);

    if (!$mahasiswa) {
        return $this->response->setJSON([
            'status' => 'error',
            'message' => 'Data mahasiswa tidak ditemukan'
        ])->setStatusCode(404);
    }

    // Hapus data mahasiswa
    $mahasiswaModel->delete($id);

    return $this->response->setJSON([
        'status' => 'success',
        'message' => 'Data mahasiswa berhasil dihapus'
    ])->setStatusCode(200);
}

}