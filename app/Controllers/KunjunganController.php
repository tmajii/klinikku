<?php

namespace App\Controllers;

use App\Models\KunjunganModel;
use App\Models\PendaftaranModel;

class KunjunganController extends BaseController
{
    protected $kunjunganModel;
    protected $pendaftaranModel;

    public function __construct()
    {
        $this->kunjunganModel = new KunjunganModel();
        $this->pendaftaranModel = new PendaftaranModel();
    }

    public function index()
    {
        // Check if AJAX request
        if ($this->request->isAJAX()) {
            return view('kunjungan/index_content');
        }
        
        return view('kunjungan/index');
    }

    public function datatable()
    {
        $request = $this->request->getPost();
        
        // Query builder with joins
        $builder = $this->kunjunganModel->builder();
        $builder->select('kunjungan.*, pendaftaran.noregistrasi, pasien.nama, pasien.norm')
                ->join('pendaftaran', 'pendaftaran.id = kunjungan.pendaftaranpasienid')
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
        $data = $this->kunjunganModel->find($id);
        return $this->response->setJSON($data);
    }

    public function getPendaftaranList()
    {
        $pendaftaran = $this->pendaftaranModel->select('pendaftaran.id, pendaftaran.noregistrasi, pasien.nama, pasien.norm')
                                              ->join('pasien', 'pasien.id = pendaftaran.pasienid')
                                              ->orderBy('pendaftaran.tglregistrasi', 'DESC')
                                              ->findAll();
        return $this->response->setJSON($pendaftaran);
    }

    public function save()
    {
        // Validation rules
        $rules = [
            'pendaftaranpasienid' => 'required|numeric',
            'jeniskunjungan' => 'required|min_length[3]',
            'tglkunjungan' => 'required|valid_date',
        ];

        if (!$this->validate($rules)) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Validasi gagal: ' . implode(', ', $this->validator->getErrors())
            ])->setStatusCode(400);
        }

        $id = $this->request->getPost('id');
        $data = [
            'pendaftaranpasienid' => $this->request->getPost('pendaftaranpasienid'),
            'jeniskunjungan' => $this->request->getPost('jeniskunjungan'),
            'tglkunjungan' => $this->request->getPost('tglkunjungan'),
        ];

        try {
            if ($id) {
                // Update
                $this->kunjunganModel->update($id, $data);
                $message = 'Data kunjungan berhasil diupdate';
            } else {
                // Insert
                $this->kunjunganModel->insert($data);
                $message = 'Data kunjungan berhasil ditambahkan';
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
            $this->kunjunganModel->delete($id);
            return $this->response->setJSON([
                'success' => true,
                'message' => 'Data kunjungan berhasil dihapus'
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
        // Get data kunjungan with details
        $kunjungan = $this->kunjunganModel->select('kunjungan.*, pendaftaran.noregistrasi, pendaftaran.tglregistrasi, pasien.nama, pasien.norm, pasien.alamat')
                                          ->join('pendaftaran', 'pendaftaran.id = kunjungan.pendaftaranpasienid')
                                          ->join('pasien', 'pasien.id = pendaftaran.pasienid')
                                          ->find($id);
        
        if (!$kunjungan) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Data kunjungan tidak ditemukan');
        }

        // Load DomPDF
        $dompdf = new \Dompdf\Dompdf();
        
        // HTML content
        $html = view('kunjungan/pdf', ['kunjungan' => $kunjungan]);
        
        // Load HTML
        $dompdf->loadHtml($html);
        
        // Setup paper
        $dompdf->setPaper('A4', 'portrait');
        
        // Render PDF
        $dompdf->render();
        
        // Output PDF
        $dompdf->stream('Kunjungan_' . $kunjungan['noregistrasi'] . '.pdf', ['Attachment' => false]);
    }

    public function pdfRekap()
    {
        // Get all data kunjungan with details
        $data['kunjungan'] = $this->kunjunganModel->select('kunjungan.*, pendaftaran.noregistrasi, pasien.nama, pasien.norm')
                                                  ->join('pendaftaran', 'pendaftaran.id = kunjungan.pendaftaranpasienid')
                                                  ->join('pasien', 'pasien.id = pendaftaran.pasienid')
                                                  ->orderBy('kunjungan.tglkunjungan', 'DESC')
                                                  ->findAll();
        $data['total'] = count($data['kunjungan']);
        $data['tanggal_cetak'] = date('d F Y H:i:s');

        // Load DomPDF
        $dompdf = new \Dompdf\Dompdf();
        
        // HTML content
        $html = view('kunjungan/pdf_rekap', $data);
        
        // Load HTML
        $dompdf->loadHtml($html);
        
        // Setup paper - landscape untuk tabel lebar
        $dompdf->setPaper('A4', 'landscape');
        
        // Render PDF
        $dompdf->render();
        
        // Output PDF
        $dompdf->stream('Rekap_Kunjungan_' . date('Y-m-d') . '.pdf', ['Attachment' => false]);
    }
}
