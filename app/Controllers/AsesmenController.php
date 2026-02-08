<?php

namespace App\Controllers;

use App\Models\AsesmenModel;
use App\Models\KunjunganModel;

class AsesmenController extends BaseController
{
    protected $asesmenModel;
    protected $kunjunganModel;

    public function __construct()
    {
        $this->asesmenModel = new AsesmenModel();
        $this->kunjunganModel = new KunjunganModel();
    }

    public function index()
    {
        if ($this->request->isAJAX()) {
            return view('asesmen/index_content');
        }
        return view('asesmen/index');
    }

    public function datatable()
    {
        
        $builder = $this->asesmenModel->builder();
        $builder->select('asesmen.*, kunjungan.jeniskunjungan, kunjungan.tglkunjungan, pendaftaran.noregistrasi, pasien.nama, pasien.norm')
                ->join('kunjungan', 'kunjungan.id = asesmen.kunjunganid')
                ->join('pendaftaran', 'pendaftaran.id = kunjungan.pendaftaranpasienid')
                ->join('pasien', 'pasien.id = pendaftaran.pasienid');
        
        $data = $builder->get()->getResultArray();
        return $this->response->setJSON([
           
            'data' => $data
        ]);
    }

    public function get($id)
    {
        $data = $this->asesmenModel->find($id);
        return $this->response->setJSON($data);
    }

    public function getKunjunganList()
    {
        $kunjungan = $this->kunjunganModel->select('kunjungan.id, kunjungan.jeniskunjungan, kunjungan.tglkunjungan, pendaftaran.noregistrasi, pasien.nama, pasien.norm')
                                          ->join('pendaftaran', 'pendaftaran.id = kunjungan.pendaftaranpasienid')
                                          ->join('pasien', 'pasien.id = pendaftaran.pasienid')
                                          ->orderBy('kunjungan.tglkunjungan', 'DESC')
                                          ->findAll();
        return $this->response->setJSON($kunjungan);
    }

    public function save()
    {
        $rules = ['kunjunganid' => 'required|numeric', 'keluhan_utama' => 'required|min_length[5]'];
        if (!$this->validate($rules)) {
            return $this->response->setJSON(['success' => false, 'message' => 'Validasi gagal: ' . implode(', ', $this->validator->getErrors())])->setStatusCode(400);
        }
        $id = $this->request->getPost('id');
        $data = ['kunjunganid' => $this->request->getPost('kunjunganid'), 'keluhan_utama' => $this->request->getPost('keluhan_utama'), 'keluhan_tambahan' => $this->request->getPost('keluhan_tambahan')];
        try {
            if ($id) {
                $this->asesmenModel->update($id, $data);
                $message = 'Data asesmen berhasil diupdate';
            } else {
                $this->asesmenModel->insert($data);
                $message = 'Data asesmen berhasil ditambahkan';
            }
            return $this->response->setJSON(['success' => true, 'message' => $message]);
        } catch (\Exception $e) {
            return $this->response->setJSON(['success' => false, 'message' => 'Terjadi kesalahan: ' . $e->getMessage()])->setStatusCode(500);
        }
    }

    public function delete($id)
    {
        try {
            $this->asesmenModel->delete($id);
            return $this->response->setJSON(['success' => true, 'message' => 'Data asesmen berhasil dihapus']);
        } catch (\Exception $e) {
            return $this->response->setJSON(['success' => false, 'message' => 'Gagal menghapus data: ' . $e->getMessage()])->setStatusCode(500);
        }
    }

    public function pdf($id)
    {
        $asesmen = $this->asesmenModel->select('asesmen.*, kunjungan.jeniskunjungan, kunjungan.tglkunjungan, pendaftaran.noregistrasi, pendaftaran.tglregistrasi, pasien.nama, pasien.norm, pasien.alamat')
                                      ->join('kunjungan', 'kunjungan.id = asesmen.kunjunganid')
                                      ->join('pendaftaran', 'pendaftaran.id = kunjungan.pendaftaranpasienid')
                                      ->join('pasien', 'pasien.id = pendaftaran.pasienid')
                                      ->find($id);
        if (!$asesmen) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Data asesmen tidak ditemukan');
        }
        $dompdf = new \Dompdf\Dompdf();
        $html = view('asesmen/pdf', ['asesmen' => $asesmen]);
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->render();
        $dompdf->stream('Asesmen_' . $asesmen['noregistrasi'] . '.pdf', ['Attachment' => false]);
    }

    public function pdfRekap()
    {
        $data['asesmen'] = $this->asesmenModel->select('asesmen.*, kunjungan.jeniskunjungan, kunjungan.tglkunjungan, pendaftaran.noregistrasi, pasien.nama, pasien.norm')
                                              ->join('kunjungan', 'kunjungan.id = asesmen.kunjunganid')
                                              ->join('pendaftaran', 'pendaftaran.id = kunjungan.pendaftaranpasienid')
                                              ->join('pasien', 'pasien.id = pendaftaran.pasienid')
                                              ->orderBy('asesmen.created_at', 'DESC')
                                              ->findAll();
        $data['total'] = count($data['asesmen']);
        $data['tanggal_cetak'] = date('d F Y H:i:s');
        $dompdf = new \Dompdf\Dompdf();
        $html = view('asesmen/pdf_rekap', $data);
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'landscape');
        $dompdf->render();
        $dompdf->stream('Rekap_Asesmen_' . date('Y-m-d') . '.pdf', ['Attachment' => false]);
    }
}
