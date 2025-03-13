<?php

namespace App\Models;

use CodeIgniter\Model;

class Mahasiswa extends Model
{
    protected $table      = 'mahasiswa';
    protected $primaryKey = 'npm_mhs'; // Sesuaikan dengan nama primary key di tabel

    protected $allowedFields = ['npm_mhs', 'nama_mhs', 'prodi', 'alamat', 'no_telp', 'email'];
}
