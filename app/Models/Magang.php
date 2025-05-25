<?php

namespace App\Models;

use CodeIgniter\Model;

class Magang extends Model
{
    protected $table = 'magang';
    protected $primaryKey = 'id_magang';
    
    protected $allowedFields = [
        'npm_mhs',
        'id_perusahaan', 
        'nidn_pembimbing',
        'tgl_mulai',
        'tgl_selesai',
        'status_magang'
    ];

    protected $useTimestamps = false;

    /**
     * Ambil data magang dengan relasi ke mahasiswa, perusahaan, dan pembimbing
     */
    public function getMagangWithRelations($id_magang = null)
    {
        $builder = $this->db->table('magang m');
        
        $builder->select('
            m.id_magang,
            m.npm_mhs,
            m.id_perusahaan,
            m.nidn_pembimbing,
            m.tgl_mulai,
            m.tgl_selesai,
            m.status_magang,
            mhs.nama_mhs,
            mhs.prodi,
            mhs.alamat as alamat_mhs,
            mhs.no_telp as no_telp_mhs,
            mhs.email as email_mhs,
            p.nama_perusahaan,
            p.alamat as alamat_perusahaan,
            p.no_telp as no_telp_perusahaan,
            p.email_perusahaan,
            pb.nama_pembimbing,
            pb.email as email_pembimbing,
            pb.no_telp as no_telp_pembimbing
        ');
        
        // JOIN dengan tabel mahasiswa
        $builder->join('mahasiswa mhs', 'm.npm_mhs = mhs.npm_mhs', 'left');
        
        // JOIN dengan tabel perusahaan
        $builder->join('perusahaan p', 'm.id_perusahaan = p.id_perusahaan', 'left');
        
        // JOIN dengan tabel pembimbing
        $builder->join('pembimbing pb', 'm.nidn_pembimbing = pb.nidn_pembimbing', 'left');
        
        // Jika ada filter ID tertentu
        if ($id_magang !== null) {
            $builder->where('m.id_magang', $id_magang);
        }
        
        $query = $builder->get();
        $results = $query->getResultArray();
        
        // Format data sesuai struktur yang diharapkan Laravel
        $formattedResults = [];
        foreach ($results as $row) {
            $formattedResults[] = [
                'id_magang' => $row['id_magang'],
                'npm_mhs' => $row['npm_mhs'],
                'id_perusahaan' => $row['id_perusahaan'],
                'nidn_pembimbing' => $row['nidn_pembimbing'],
                'tgl_mulai' => $row['tgl_mulai'],
                'tgl_selesai' => $row['tgl_selesai'],
                'status_magang' => $row['status_magang'],
                'mahasiswa' => [
                    'npm_mhs' => $row['npm_mhs'],
                    'nama_mhs' => $row['nama_mhs'],
                    'prodi' => $row['prodi'],
                    'alamat' => $row['alamat_mhs'],
                    'no_telp' => $row['no_telp_mhs'],
                    'email' => $row['email_mhs']
                ],
                'perusahaan' => [
                    'id_perusahaan' => $row['id_perusahaan'],
                    'nama_perusahaan' => $row['nama_perusahaan'],
                    'alamat' => $row['alamat_perusahaan'],
                    'no_telp' => $row['no_telp_perusahaan'],
                    'email_perusahaan' => $row['email_perusahaan']
                ],
                'pembimbing' => [
                    'nidn_pembimbing' => $row['nidn_pembimbing'],
                    'nama_pembimbing' => $row['nama_pembimbing'],
                    'email' => $row['email_pembimbing'],
                    'no_telp' => $row['no_telp_pembimbing']
                ]
            ];
        }
        
        return $formattedResults;
    }

    /**
     * Generate ID Magang otomatis (karena menggunakan AUTO_INCREMENT, method ini mungkin tidak dibutuhkan)
     */
    public function generateIdMagang()
    {
        // Karena id_magang adalah AUTO_INCREMENT, kita tidak perlu generate manual
        // Method ini bisa dihapus atau digunakan untuk keperluan lain
        return null;
    }

    /**
     * Validasi apakah NPM mahasiswa ada
     */
    public function isValidMahasiswa($npm_mhs)
    {
        $mahasiswaModel = new \App\Models\Mahasiswa();
        return $mahasiswaModel->find($npm_mhs) !== null;
    }

    /**
     * Validasi apakah ID perusahaan ada  
     */
    public function isValidPerusahaan($id_perusahaan)
    {
        $perusahaanModel = new \App\Models\Perusahaan();
        return $perusahaanModel->find($id_perusahaan) !== null;
    }

    /**
     * Validasi apakah NIDN pembimbing ada
     */
    public function isValidPembimbing($nidn_pembimbing)
    {
        $pembimbingModel = new \App\Models\Pembimbing();
        return $pembimbingModel->find($nidn_pembimbing) !== null;
    }
}