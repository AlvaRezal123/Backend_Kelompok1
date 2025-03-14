<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\ViewMagang;
use Dompdf\Dompdf;
use Dompdf\Options;

class ViewController extends BaseController
{
    protected $vMagangModel;

    public function __construct()
    {
        $this->vMagangModel = new ViewMagang();
    }

    // API untuk mendapatkan data magang dalam format JSON
    public function index()
    {
        $magang = $this->vMagangModel->getMagangWithNames(); 

        if (empty($magang)) {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'Data magang tidak ditemukan'
            ])->setStatusCode(404);
        }

        return $this->response->setJSON($magang);
    }

    // API untuk generate PDF
    public function generatePDF()
    {
        $magang = $this->vMagangModel->getMagangWithNames();

        if (empty($magang)) {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'Data magang tidak ditemukan'
            ])->setStatusCode(404);
        }

        // 1. Membuat tampilan HTML untuk PDF
        $html = '<h2 style="text-align:center;">Laporan Data Magang</h2>';
        $html .= '<table border="1" cellpadding="5" cellspacing="0" style="width:100%; border-collapse: collapse;">
                    <tr>
                        <th style="background-color: #f2f2f2;">No</th>
                        <th style="background-color: #f2f2f2;">Nama</th>
                        <th style="background-color: #f2f2f2;">Posisi</th>
                        <th style="background-color: #f2f2f2;">Perusahaan</th>
                    </tr>';
        
        $no = 1;
        foreach ($magang as $row) {
            $html .= '<tr>
                        <td>' . $no++ . '</td>
                        <td>' . $row['nama'] . '</td>
                        <td>' . $row['posisi'] . '</td>
                        <td>' . $row['perusahaan'] . '</td>
                    </tr>';
        }
        $html .= '</table>';

        // 2. Konfigurasi domPDF
        $options = new Options();
        $options->set('defaultFont', 'Arial');
        $dompdf = new Dompdf($options);

        // 3. Load HTML ke domPDF
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->render();

        // 4. Simpan PDF ke file sementara
        $output = $dompdf->output();
        $pdfPath = WRITEPATH . 'pdfs/data_magang.pdf';
        file_put_contents($pdfPath, $output);

        // 5. Kembalikan response sebagai file PDF
        return $this->response->download($pdfPath, null)->setFileName('data_magang.pdf');
    }
}
