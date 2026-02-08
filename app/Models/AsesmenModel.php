<?php

namespace App\Models;

use CodeIgniter\Model;

class AsesmenModel extends Model
{
    protected $table = 'asesmen';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $returnType = 'array';
    protected $useSoftDeletes = false;
    protected $allowedFields = ['kunjunganid', 'keluhan_utama', 'keluhan_tambahan'];
    protected $useTimestamps = true;
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';

    public function getAsesmenWithDetails()
    {
        return $this->select('asesmen.*, kunjungan.jeniskunjungan, kunjungan.tglkunjungan, pendaftaran.noregistrasi, pasien.nama, pasien.norm')
                    ->join('kunjungan', 'kunjungan.id = asesmen.kunjunganid')
                    ->join('pendaftaran', 'pendaftaran.id = kunjungan.pendaftaranpasienid')
                    ->join('pasien', 'pasien.id = pendaftaran.pasienid')
                    ->findAll();
    }
}
