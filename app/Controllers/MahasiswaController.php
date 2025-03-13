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
                    'user' => [
                        'id_user' => $user['id_user'],
                        'username' => $user['username'],
                        'role' => $user['role']
                    ]
                ]);
            } else {
                return $this->respond(['status' => 'error', 'message' => 'Password salah!'], 401);
            }
        } else {
            return $this->respond(['status' => 'error', 'message' => 'Username tidak ditemukan!'], 404);
        }
    }
}
