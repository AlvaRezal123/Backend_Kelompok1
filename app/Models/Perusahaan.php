<?php

namespace App\Models;

use CodeIgniter\Model;

class Perusahaan extends Model
{
    protected $table = 'perusahaan';
    protected $primaryKey = 'id_perusahaan';
    protected $useAutoIncrement = true;
    protected $allowedFields = ['nama_perusahaan', 'no_telp', 'alamat', 'email_perusahaan'];
}
