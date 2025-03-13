<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\ViewMagang;

class ViewController extends BaseController
{
    protected $vMagangModel;

    public function __construct()
    {
        $this->vMagangModel = new ViewMagang();
    }

    public function index()
    {
        $magang = $this->vMagangModel->getMagangWithNames(); // Ambil data dari model baru

        if (empty($magang)) {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'Data magang tidak ditemukan'
            ])->setStatusCode(404);
        }

        return $this->response->setJSON($magang);
    }
}
