<?php

namespace App\Models;

use CodeIgniter\Model;

class Magang extends Model
{
    protected $table = 'magang';
    protected $primaryKey = 'id_magang';
    protected $allowedFields = [
        'id_magang',
        'npm_mhs',
        'id_perusahaan',
        'nidn_pembimbing',
        'tgl_mulai',
        'tgl_selesai',
        'status_magang'
    ];
    public $incrementing = false; // Karena id_magang bukan auto-increment

    // Fungsi untuk generate ID Magang
    public function generateIdMagang()
    {
        // Ambil ID terakhir dari database
        $lastData = $this->orderBy('id_magang', 'DESC')->first();

        if ($lastData) {
            // Ambil nomor urut dari ID terakhir
            $lastId = intval(substr($lastData['id_magang'], -3));
            $newId = $lastId + 1;
        } else {
            // Jika belum ada data, mulai dari 001
            $newId = 1;
        }

        // Format ID baru (contoh: MG2025001)
        return 'MG' . date('Y') . str_pad($newId, 3, '0', STR_PAD_LEFT);
    }

    public function generatePDF()
{
    $magang = $this->vMagangModel->getMagangWithNames();

    if (empty($magang)) {
        return $this->response->setJSON([
            'status' => 'error',
            'message' => 'Data magang tidak ditemukan'
        ])->setStatusCode(404);
    }

    // Debug cek data
    echo '<pre>';
    print_r($magang);
    echo '</pre>';
    exit;
}

}
