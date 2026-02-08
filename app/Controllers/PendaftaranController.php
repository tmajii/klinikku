<?php

namespace App\Controllers;

use App\Models\PendaftaranModel;
use App\Models\PasienModel;

class PendaftaranController extends BaseController
{
    protected $pendaftaranModel;
    protected $pasienModel;

    public function __construct()
    {
        $this->pendaftaranModel = new PendaftaranModel();
        $this->pasienModel = new PasienModel();
    }

    public function index()
    {
        // Check if AJAX request
        if ($this->request->isAJAX()) {
            return view('pendaftaran/index_content');
        }
        
        return view('pendaftaran/index');
    }

    public function datatable()
    {
        $request = $this->request->getPost();
        
        // Query builder with join
        $builder = $this->pendaftaranModel->builder();
        $builder->select('pendaftaran.*, pasien.nama, pasien.norm')
                ->join('pasien', 'pasien.id = pendaftaran.pasienid');
        // Get data
        $data = $builder->get()
                       ->getResultArray();

        // Response
        return $this->response->setJSON([
            'data' => $data
        ]);
    }

    public function get($id)
    {
        $data = $this->pendaftaranModel->find($id);
        return $this->response->setJSON($data);
    }

    public function getPasienList()
    {
        $pasien = $this->pasienModel->select('id, norm, nama')->findAll();
        return $this->response->setJSON($pasien);
    }

    public function save()
    {
        // Validation rules
        $rules = [
            'noregistrasi' => 'required|min_length[3]',
            'pasienid' => 'required|numeric',
            'tglregistrasi' => 'required|valid_date',
        ];

        if (!$this->validate($rules)) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Validasi gagal: ' . implode(', ', $this->validator->getErrors())
            ])->setStatusCode(400);
        }

        $id = $this->request->getPost('id');
        $data = [
            'noregistrasi' => $this->request->getPost('noregistrasi'),
            'pasienid' => $this->request->getPost('pasienid'),
            'tglregistrasi' => $this->request->getPost('tglregistrasi'),
        ];

        try {
            if ($id) {
                // Update
                $this->pendaftaranModel->update($id, $data);
                $message = 'Data pendaftaran berhasil diupdate';
            } else {
                // Insert
                $this->pendaftaranModel->insert($data);
                $message = 'Data pendaftaran berhasil ditambahkan';
            }

            return $this->response->setJSON([
                'success' => true,
                'message' => $message
            ]);
        } catch (\Exception $e) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ])->setStatusCode(500);
        }
    }

    public function delete($id)
    {
        try {
            $this->pendaftaranModel->delete($id);
            return $this->response->setJSON([
                'success' => true,
                'message' => 'Data pendaftaran berhasil dihapus'
            ]);
        } catch (\Exception $e) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Gagal menghapus data: ' . $e->getMessage()
            ])->setStatusCode(500);
        }
    }

    public function pdf($id)
    {
        // Get data pendaftaran with pasien
        $pendaftaran = $this->pendaftaranModel->select('pendaftaran.*, pasien.nama, pasien.norm, pasien.alamat')
                                              ->join('pasien', 'pasien.id = pendaftaran.pasienid')
                                              ->find($id);
        
        if (!$pendaftaran) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Data pendaftaran tidak ditemukan');
        }

        // Load DomPDF
        $dompdf = new \Dompdf\Dompdf();
        
        // HTML content
        $html = view('pendaftaran/pdf', ['pendaftaran' => $pendaftaran]);
        
        // Load HTML
        $dompdf->loadHtml($html);
        
        // Setup paper
        $dompdf->setPaper('A4', 'portrait');
        
        // Render PDF
        $dompdf->render();
        
        // Output PDF
        $dompdf->stream('Pendaftaran_' . $pendaftaran['noregistrasi'] . '.pdf', ['Attachment' => false]);
    }

    public function pdfRekap()
    {
        // Get all data pendaftaran with pasien
        $data['pendaftaran'] = $this->pendaftaranModel->select('pendaftaran.*, pasien.nama, pasien.norm')
                                                      ->join('pasien', 'pasien.id = pendaftaran.pasienid')
                                                      ->orderBy('pendaftaran.tglregistrasi', 'DESC')
                                                      ->findAll();
        $data['total'] = count($data['pendaftaran']);
        $data['tanggal_cetak'] = date('d F Y H:i:s');

        // Load DomPDF
        $dompdf = new \Dompdf\Dompdf();
        
        // HTML content
        $html = view('pendaftaran/pdf_rekap', $data);
        
        // Load HTML
        $dompdf->loadHtml($html);
        
        // Setup paper - landscape untuk tabel lebar
        $dompdf->setPaper('A4', 'landscape');
        
        // Render PDF
        $dompdf->render();
        
        // Output PDF
        $dompdf->stream('Rekap_Pendaftaran_' . date('Y-m-d') . '.pdf', ['Attachment' => false]);
    }

    // Legacy methods for backward compatibility
    public function create()
    {
        $data['pasien'] = $this->pasienModel->findAll();
        return view('pendaftaran/create', $data);
    }

    public function store()
    {
        $this->pendaftaranModel->save([
            'pasienid' => $this->request->getPost('pasienid'),
            'noregistrasi' => $this->request->getPost('noregistrasi'),
            'tglregistrasi' => $this->request->getPost('tglregistrasi'),
        ]);

        return redirect()->to('/pendaftaran')->with('success', 'Pendaftaran berhasil');
    }
}
