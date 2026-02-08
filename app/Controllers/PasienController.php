<?php

namespace App\Controllers;

use App\Models\PasienModel;

class PasienController extends BaseController
{
    protected $pasienModel;

    public function __construct()
    {
        $this->pasienModel = new PasienModel();
    }

    public function index()
    {
        // Check if AJAX request
        if ($this->request->isAJAX()) {
            return view('pasien/index_content');
        }
        
        return view('pasien/index');
    }

    public function datatable()
    {
        $request = $this->request->getPost();
        
       
        
        
        // Query builder
        $builder = $this->pasienModel->builder();
        
        
        
       
        
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
        $data = $this->pasienModel->find($id);
        return $this->response->setJSON($data);
    }

    public function save()
    {
        // Validation rules
        $rules = [
            'nama' => 'required|min_length[3]',
            'norm' => 'required|min_length[3]',
        ];

        if (!$this->validate($rules)) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Validasi gagal: ' . implode(', ', $this->validator->getErrors())
            ])->setStatusCode(400);
        }

        $id = $this->request->getPost('id');
        $data = [
            'nama' => $this->request->getPost('nama'),
            'norm' => $this->request->getPost('norm'),
            'alamat' => $this->request->getPost('alamat'),
        ];

        try {
            if ($id) {
                // Update
                $this->pasienModel->update($id, $data);
                $message = 'Data pasien berhasil diupdate';
            } else {
                // Insert
                $this->pasienModel->insert($data);
                $message = 'Data pasien berhasil ditambahkan';
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
            $this->pasienModel->delete($id);
            return $this->response->setJSON([
                'success' => true,
                'message' => 'Data pasien berhasil dihapus'
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
        // Get data pasien
        $pasien = $this->pasienModel->find($id);
        
        if (!$pasien) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Data pasien tidak ditemukan');
        }

        // Load DomPDF
        $dompdf = new \Dompdf\Dompdf();
        
        // HTML content
        $html = view('pasien/pdf', ['pasien' => $pasien]);
        
        // Load HTML
        $dompdf->loadHtml($html);
        
        // Setup paper
        $dompdf->setPaper('A4', 'portrait');
        
        // Render PDF
        $dompdf->render();
        
        // Output PDF
        $dompdf->stream('Pasien_' . $pasien['norm'] . '.pdf', ['Attachment' => false]);
    }

    public function pdfRekap()
    {
        // Get all data pasien
        $data['pasien'] = $this->pasienModel->orderBy('norm', 'ASC')->findAll();
        $data['total'] = count($data['pasien']);
        $data['tanggal_cetak'] = date('d F Y H:i:s');

        // Load DomPDF
        $dompdf = new \Dompdf\Dompdf();
        
        // HTML content
        $html = view('pasien/pdf_rekap', $data);
        
        // Load HTML
        $dompdf->loadHtml($html);
        
        // Setup paper - landscape untuk tabel lebar
        $dompdf->setPaper('A4', 'landscape');
        
        // Render PDF
        $dompdf->render();
        
        // Output PDF
        $dompdf->stream('Rekap_Pasien_' . date('Y-m-d') . '.pdf', ['Attachment' => false]);
    }

    // Legacy methods for backward compatibility
    public function create()
    {
        return view('pasien/create');
    }

    public function store()
    {
        $this->pasienModel->save([
            'nama' => $this->request->getPost('nama'),
            'norm' => $this->request->getPost('norm'),
            'alamat' => $this->request->getPost('alamat'),
        ]);

        return redirect()->to('/pasien')->with('success', 'Data pasien berhasil ditambahkan');
    }

    public function edit($id)
    {
        $data['pasien'] = $this->pasienModel->find($id);
        return view('pasien/edit', $data);
    }

    public function update($id)
    {
        $this->pasienModel->update($id, [
            'nama' => $this->request->getPost('nama'),
            'norm' => $this->request->getPost('norm'),
            'alamat' => $this->request->getPost('alamat'),
        ]);

        return redirect()->to('/pasien')->with('success', 'Data pasien berhasil diupdate');
    }
}
