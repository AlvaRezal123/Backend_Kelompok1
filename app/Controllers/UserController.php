<?php

namespace App\Controllers;

use App\Models\UserModel;
use CodeIgniter\RESTful\ResourceController;

class UserController extends ResourceController
{
    public function register()
    {
        $userModel = new UserModel();
        $json = $this->request->getJSON();

        // Validasi input
        if (!isset($json->username) || !isset($json->password) || !isset($json->role)) {
            return $this->respond(['status' => 'error', 'message' => 'Semua field harus diisi!'], 400);
        }

        // Cek apakah username sudah ada
        if ($userModel->getUserByUsername($json->username)) {
            return $this->respond(['status' => 'error', 'message' => 'Username sudah terdaftar!'], 400);
        }

        // Simpan user baru dengan password terenkripsi
        $data = [
            'username' => $json->username,
            'password' => password_hash($json->password, PASSWORD_DEFAULT),
            'role' => $json->role
        ];

        $userModel->insert($data);

        return $this->respond(['status' => 'success', 'message' => 'Registrasi berhasil!']);
    }

    public function login()
    {
        $userModel = new UserModel();
        $json = $this->request->getJSON();

        // Validasi input
        if (!isset($json->username) || !isset($json->password)) {
            return $this->respond(['status' => 'error', 'message' => 'Username dan password harus diisi!'], 400);
        }

        // Cari user berdasarkan username
        $user = $userModel->getUserByUsername($json->username);

        if ($user) {
            // Verifikasi password
            if (password_verify($json->password, $user['password'])) {
                return $this->respond([
                    'status' => 'success',
                    'message' => 'Login berhasil!',
                    
                ]);
            } else {
                return $this->respond(['status' => 'error', 'message' => 'Password salah!'], 401);
            }
        } else {
            return $this->respond(['status' => 'error', 'message' => 'Username tidak ditemukan!'], 404);
        }
    }

    // Menampilkan semua user yang sudah terdaftar
    public function getAllUsers()
    {
        $userModel = new UserModel();
        $users = $userModel->findAll(); // Mengambil semua data user dari database
    
        return $this->respond($users); // Mengembalikan data langsung tanpa pembungkus "status"
    }
    

// Menghapus user berdasarkan id_user
public function deleteUser($id)
{
    $userModel = new UserModel();

    // Cek apakah user dengan ID tersebut ada
    $user = $userModel->find($id);
    if (!$user) {
        return $this->respond(['status' => 'error', 'message' => 'User tidak ditemukan!'], 404);
    }

    // Hapus user dari database
    $userModel->delete($id);
    return $this->respond(['status' => 'success', 'message' => 'User berhasil dihapus!']);
}

public function updateUser($id_user)
{
    $userModel = new UserModel();
    
    // Ambil data dari request
    $json = $this->request->getJSON();
    
    // Cek apakah user dengan ID tersebut ada
    $user = $userModel->find($id_user);
    if (!$user) {
        return $this->respond(['status' => 'error', 'message' => 'User tidak ditemukan!'], 404);
    }

    // Data yang akan diperbarui
    $data = [];
    if (isset($json->username)) {
        $data['username'] = $json->username;
    }
    if (isset($json->role)) {
        $data['role'] = $json->role;
    }
    if (isset($json->password)) {
        $data['password'] = password_hash($json->password, PASSWORD_DEFAULT); // Enkripsi password baru
    }

    // Update data
    $userModel->update($id_user, $data);

    return $this->respond([
        'status' => 'success',
        'message' => 'User berhasil diperbarui!',
    ]);
}


}
