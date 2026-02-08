<?php

namespace App\Controllers;

use App\Models\PasienModel;
use App\Models\PendaftaranModel;
use App\Models\KunjunganModel;
use App\Models\AsesmenModel;
use App\Models\DiagnosaModel;
use App\Models\UserModel;

class Home extends BaseController
{
    public function index(): string
    {
        // Get statistics
        $pasienModel = new PasienModel();
        $pendaftaranModel = new PendaftaranModel();
        $kunjunganModel = new KunjunganModel();
        $asesmenModel = new AsesmenModel();
        $diagnosaModel = new DiagnosaModel();
        $userModel = new UserModel();
        
        $data = [
            'total_pasien' => $pasienModel->countAll(),
            'total_pendaftaran' => $pendaftaranModel->countAll(),
            'total_kunjungan' => $kunjunganModel->countAll(),
            'total_asesmen' => $asesmenModel->countAll(),
            'total_diagnosa' => $diagnosaModel->countAll(),
            'total_users' => $userModel->countAll(),
            
            // Get recent data
            'recent_pasien' => $pasienModel->orderBy('created_at', 'DESC')->limit(5)->findAll(),
            'recent_pendaftaran' => $pendaftaranModel
                ->select('pendaftaran.*, pasien.nama, pasien.norm')
                ->join('pasien', 'pasien.id = pendaftaran.pasienid')
                ->orderBy('pendaftaran.created_at', 'DESC')
                ->limit(5)
                ->findAll(),
            'recent_kunjungan' => $kunjunganModel
                ->select('kunjungan.*, pendaftaran.noregistrasi, pasien.nama, pasien.norm')
                ->join('pendaftaran', 'pendaftaran.id = kunjungan.pendaftaranpasienid')
                ->join('pasien', 'pasien.id = pendaftaran.pasienid')
                ->orderBy('kunjungan.created_at', 'DESC')
                ->limit(5)
                ->findAll(),
        ];
        
        // Check if AJAX request
        if ($this->request->isAJAX()) {
            return view('dashboard_content', $data);
        }
        
        return view('dashboard', $data);
    }
}
