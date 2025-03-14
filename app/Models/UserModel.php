<?php

namespace App\Models;

use CodeIgniter\Model;

class UserModel extends Model
{
    protected $table = 'user'; // Nama tabel di database
    protected $primaryKey = 'id_user'; // Primary key
    protected $allowedFields = ['username', 'password', 'role']; // Kolom yang boleh diisi

    public function getUserByUsername($username)
    {
        return $this->where('username', $username)->first();
    }
}
