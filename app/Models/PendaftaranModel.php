<?php

namespace App\Models;

use CodeIgniter\Model;

class PendaftaranModel extends Model
{
    protected $table = 'pendaftaran';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $returnType = 'array';
    protected $useSoftDeletes = false;
    protected $allowedFields = ['pasienid', 'noregistrasi', 'tglregistrasi'];
    protected $useTimestamps = true;
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';

    public function getPendaftaranWithPasien()
    {
        return $this->select('pendaftaran.*, pasien.nama, pasien.norm')
                    ->join('pasien', 'pasien.id = pendaftaran.pasienid')
                    ->findAll();
    }
}
