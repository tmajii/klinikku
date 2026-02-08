<?php

namespace App\Controllers;

use App\Models\DiagnosaModel;
use App\Models\AsesmenModel;
use App\Models\KunjunganModel;

class DiagnosaController extends BaseController
{
    protected $diagnosaModel;
    protected $asesmenModel;
    protected $kunjunganModel;

    public function __construct()
    {
        $this->diagnosaModel = new DiagnosaModel();
        $this->asesmenModel = new AsesmenModel();
        $this->kunjunganModel = new KunjunganModel();
    }

    public function index()
    {
        // Get asesmen with related data for modal dropdown
        $data['asesmen'] = $this->asesmenModel
            ->select('asesmen.*, kunjungan.jeniskunjungan, kunjungan.tglkunjungan, pasien.nama, pasien.norm, pendaftaran.noregistrasi')
            ->join('kunjungan', 'kunjungan.id = asesmen.kunjunganid')
            ->join('pendaftaran', 'pendaftaran.id = kunjungan.pendaftaranpasienid')
            ->join('pasien', 'pasien.id = pendaftaran.pasienid')
            ->findAll();
        
        // Check if AJAX request
        if ($this->request->isAJAX()) {
            return view('diagnosa/index_content', $data);
        }
        
        return view('diagnosa/index', $data);
    }

    public function datatable()
    {
        $request = $this->request->getPost();
        
        
        
        
        
        // Query builder with joins
        $builder = $this->diagnosaModel->builder();
        $builder->select('diagnosa.*, pasien.nama, pasien.norm')
                ->join('asesmen', 'asesmen.id = diagnosa.asesmenid')
                ->join('kunjungan', 'kunjungan.id = asesmen.kunjunganid')
                ->join('pendaftaran', 'pendaftaran.id = kunjungan.pendaftaranpasienid')
                ->join('pasien', 'pasien.id = pendaftaran.pasienid');
        
        
        // Get data
        $data = $builder
                       ->get()
                       ->getResultArray();
        
        // Response
        return $this->response->setJSON([
           
            'data' => $data
        ]);
    }

    public function get($id)
    {
        $data = $this->diagnosaModel->find($id);
        return $this->response->setJSON($data);
    }

    public function save()
    {
        // Validation rules
        $rules = [
            'asesmenid' => 'required|numeric',
            'nama_diagnosa' => 'required|min_length[3]',
            'jenis_diagnosa' => 'required|in_list[primer,sekunder]',
        ];

        if (!$this->validate($rules)) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Validasi gagal: ' . implode(', ', $this->validator->getErrors())
            ])->setStatusCode(400);
        }

        $id = $this->request->getPost('id');
        $data = [
            'asesmenid' => $this->request->getPost('asesmenid'),
            'kode_icd' => $this->request->getPost('kode_icd'),
            'nama_diagnosa' => $this->request->getPost('nama_diagnosa'),
            'jenis_diagnosa' => $this->request->getPost('jenis_diagnosa'),
            'keterangan' => $this->request->getPost('keterangan'),
        ];

        try {
            if ($id) {
                // Update
                $this->diagnosaModel->update($id, $data);
                $message = 'Diagnosa berhasil diupdate';
            } else {
                // Insert
                $this->diagnosaModel->insert($data);
                $message = 'Diagnosa berhasil ditambahkan';
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
            $this->diagnosaModel->delete($id);
            return $this->response->setJSON([
                'success' => true,
                'message' => 'Diagnosa berhasil dihapus'
            ]);
        } catch (\Exception $e) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Gagal menghapus data: ' . $e->getMessage()
            ])->setStatusCode(500);
        }
    }

    public function create()
    {
        // Get asesmen with related data
        $data['asesmen'] = $this->asesmenModel
            ->select('asesmen.*, kunjungan.jeniskunjungan, kunjungan.tglkunjungan, pasien.nama, pasien.norm, pendaftaran.noregistrasi')
            ->join('kunjungan', 'kunjungan.id = asesmen.kunjunganid')
            ->join('pendaftaran', 'pendaftaran.id = kunjungan.pendaftaranpasienid')
            ->join('pasien', 'pasien.id = pendaftaran.pasienid')
            ->findAll();
        
        return view('diagnosa/create', $data);
    }

    public function store()
    {
        $this->diagnosaModel->save([
            'asesmenid' => $this->request->getPost('asesmenid'),
            'kode_icd' => $this->request->getPost('kode_icd'),
            'nama_diagnosa' => $this->request->getPost('nama_diagnosa'),
            'jenis_diagnosa' => $this->request->getPost('jenis_diagnosa'),
            'keterangan' => $this->request->getPost('keterangan'),
        ]);

        return redirect()->to('/diagnosa')->with('success', 'Diagnosa berhasil ditambahkan');
    }

    public function edit($id)
    {
        $data['diagnosa'] = $this->diagnosaModel->find($id);
        $data['asesmen'] = $this->asesmenModel
            ->select('asesmen.*, kunjungan.jeniskunjungan, kunjungan.tglkunjungan, pasien.nama, pasien.norm, pendaftaran.noregistrasi')
            ->join('kunjungan', 'kunjungan.id = asesmen.kunjunganid')
            ->join('pendaftaran', 'pendaftaran.id = kunjungan.pendaftaranpasienid')
            ->join('pasien', 'pasien.id = pendaftaran.pasienid')
            ->findAll();
        
        return view('diagnosa/edit', $data);
    }

    public function update($id)
    {
        $this->diagnosaModel->update($id, [
            'asesmenid' => $this->request->getPost('asesmenid'),
            'kode_icd' => $this->request->getPost('kode_icd'),
            'nama_diagnosa' => $this->request->getPost('nama_diagnosa'),
            'jenis_diagnosa' => $this->request->getPost('jenis_diagnosa'),
            'keterangan' => $this->request->getPost('keterangan'),
        ]);

        return redirect()->to('/diagnosa')->with('success', 'Diagnosa berhasil diupdate');
    }

    public function getAsesmenList()
    {
        $asesmen = $this->asesmenModel->select('asesmen.id, asesmen.keluhan_utama, kunjungan.jeniskunjungan, kunjungan.tglkunjungan, pendaftaran.noregistrasi, pasien.nama, pasien.norm')
                                      ->join('kunjungan', 'kunjungan.id = asesmen.kunjunganid')
                                      ->join('pendaftaran', 'pendaftaran.id = kunjungan.pendaftaranpasienid')
                                      ->join('pasien', 'pasien.id = pendaftaran.pasienid')
                                      ->orderBy('asesmen.created_at', 'DESC')
                                      ->findAll();
        return $this->response->setJSON($asesmen);
    }

    public function pdf($id)
    {
        // Get data diagnosa with details
        $diagnosa = $this->diagnosaModel->select('diagnosa.*, asesmen.keluhan_utama, asesmen.keluhan_tambahan, kunjungan.jeniskunjungan, kunjungan.tglkunjungan, pendaftaran.noregistrasi, pendaftaran.tglregistrasi, pasien.nama, pasien.norm, pasien.alamat')
                                        ->join('asesmen', 'asesmen.id = diagnosa.asesmenid')
                                        ->join('kunjungan', 'kunjungan.id = asesmen.kunjunganid')
                                        ->join('pendaftaran', 'pendaftaran.id = kunjungan.pendaftaranpasienid')
                                        ->join('pasien', 'pasien.id = pendaftaran.pasienid')
                                        ->find($id);
        
        if (!$diagnosa) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Data diagnosa tidak ditemukan');
        }

        // Load DomPDF
        $dompdf = new \Dompdf\Dompdf();
        
        // HTML content
        $html = view('diagnosa/pdf', ['diagnosa' => $diagnosa]);
        
        // Load HTML
        $dompdf->loadHtml($html);
        
        // Setup paper
        $dompdf->setPaper('A4', 'portrait');
        
        // Render PDF
        $dompdf->render();
        
        // Output PDF
        $dompdf->stream('Diagnosa_' . $diagnosa['noregistrasi'] . '.pdf', ['Attachment' => false]);
    }

    public function pdfRekap()
    {
        // Get all data diagnosa with details
        $diagnosaData = $this->diagnosaModel->select('diagnosa.*, asesmen.keluhan_utama, kunjungan.jeniskunjungan, kunjungan.tglkunjungan, pendaftaran.noregistrasi, pasien.nama, pasien.norm')
                                                ->join('asesmen', 'asesmen.id = diagnosa.asesmenid')
                                                ->join('kunjungan', 'kunjungan.id = asesmen.kunjunganid')
                                                ->join('pendaftaran', 'pendaftaran.id = kunjungan.pendaftaranpasienid')
                                                ->join('pasien', 'pasien.id = pendaftaran.pasienid')
                                                ->orderBy('diagnosa.created_at', 'DESC')
                                                ->findAll();

        // Debug: Check if data exists
        if (empty($diagnosaData)) {
            // Try to get raw diagnosa data
            $rawDiagnosa = $this->diagnosaModel->findAll();
            if (empty($rawDiagnosa)) {
                die('Tidak ada data diagnosa di database. Silakan jalankan seeder terlebih dahulu: php spark db:seed TestDataSeeder');
            } else {
                die('Data diagnosa ada (' . count($rawDiagnosa) . ' records), tapi query join gagal. Periksa relasi tabel.');
            }
        }
        
        $data['diagnosa'] = $diagnosaData;
        $data['total'] = count($data['diagnosa']);
        $data['tanggal_cetak'] = date('d F Y H:i:s');

        // Load DomPDF
        $dompdf = new \Dompdf\Dompdf();
        
        // HTML content
        $html = view('diagnosa/pdf_rekap', $data);
        
        // Load HTML
        $dompdf->loadHtml($html);
        
        // Setup paper - landscape untuk tabel lebar
        $dompdf->setPaper('A4', 'landscape');
        
        // Render PDF
        $dompdf->render();
        
        // Output PDF
        $dompdf->stream('Rekap_Diagnosa_' . date('Y-m-d') . '.pdf', ['Attachment' => false]);
    }
}
