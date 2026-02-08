<?php

namespace App\Models;

use CodeIgniter\Model;

class DiagnosaModel extends Model
{
    protected $table = 'diagnosa';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $returnType = 'array';
    protected $useSoftDeletes = false;
    protected $allowedFields = ['asesmenid', 'kode_icd', 'nama_diagnosa', 'jenis_diagnosa', 'keterangan'];
    protected $useTimestamps = true;
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';

    public function getDiagnosaWithAsesmen()
    {
        return $this->select('diagnosa.*, asesmen.keluhan_utama, kunjungan.jeniskunjungan, pasien.nama, pasien.norm')
                    ->join('asesmen', 'asesmen.id = diagnosa.asesmenid')
                    ->join('kunjungan', 'kunjungan.id = asesmen.kunjunganid')
                    ->join('pendaftaran', 'pendaftaran.id = kunjungan.pendaftaranpasienid')
                    ->join('pasien', 'pasien.id = pendaftaran.pasienid')
                    ->findAll();
    }

    public function getDiagnosaByAsesmen($asesmenid)
    {
        return $this->where('asesmenid', $asesmenid)->findAll();
    }
}
