<?php

namespace App\Models;

use CodeIgniter\Model;

class KunjunganModel extends Model
{
    protected $table = 'kunjungan';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $returnType = 'array';
    protected $useSoftDeletes = false;
    protected $allowedFields = ['pendaftaranpasienid', 'jeniskunjungan', 'tglkunjungan'];
    protected $useTimestamps = true;
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';

    public function getKunjunganWithDetails()
    {
        return $this->select('kunjungan.*, pendaftaran.noregistrasi, pasien.nama, pasien.norm')
                    ->join('pendaftaran', 'pendaftaran.id = kunjungan.pendaftaranpasienid')
                    ->join('pasien', 'pasien.id = pendaftaran.pasienid')
                    ->findAll();
    }
}
