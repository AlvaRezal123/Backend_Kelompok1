<?php

namespace App\Models;

use CodeIgniter\Model;

class ViewMagang extends Model
{
    protected $table = 'magang'; // Menggunakan tabel utama
    protected $primaryKey = 'id_magang';

    // Fungsi untuk mendapatkan data magang dengan nama mahasiswa, pembimbing, dan perusahaan
    public function getMagangWithNames()
    {
        return $this->select('
                magang.id_magang, 
                mahasiswa.nama_mhs, 
                pembimbing.nama_pembimbing, 
                perusahaan.nama_perusahaan, 
                magang.tgl_mulai, 
                magang.tgl_selesai, 
                magang.status_magang
            ')
            ->join('mahasiswa', 'mahasiswa.npm_mhs = magang.npm_mhs')
            ->join('pembimbing', 'pembimbing.nidn_pembimbing = magang.nidn_pembimbing')
            ->join('perusahaan', 'perusahaan.id_perusahaan = magang.id_perusahaan')
            ->findAll();
    }
}
