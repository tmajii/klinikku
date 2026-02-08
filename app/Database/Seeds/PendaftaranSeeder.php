<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class PendaftaranSeeder extends Seeder
{
    public function run()
    {
        // Get pasien IDs
        $db = \Config\Database::connect();
        $pasienIds = $db->table('pasien')->select('id')->get()->getResultArray();
        
        if (empty($pasienIds)) {
            echo "Tidak ada data pasien. Jalankan seeder pasien terlebih dahulu.\n";
            return;
        }
        
        $data = [];
        $today = date('Y-m-d');
        
        // Generate 15 pendaftaran dengan tanggal bervariasi
        for ($i = 1; $i <= 15; $i++) {
            // Random pasien
            $randomPasien = $pasienIds[array_rand($pasienIds)];
            
            // Random date (7 hari ke belakang sampai 7 hari ke depan)
            $randomDays = rand(-7, 7);
            $tglRegistrasi = date('Y-m-d', strtotime("$randomDays days", strtotime($today)));
            
            $data[] = [
                'noregistrasi' => 'REG' . date('Ymd') . str_pad($i, 4, '0', STR_PAD_LEFT),
                'pasienid' => $randomPasien['id'],
                'tglregistrasi' => $tglRegistrasi,
                'created_at' => date('Y-m-d H:i:s', strtotime("-$i hours")),
                'updated_at' => date('Y-m-d H:i:s', strtotime("-$i hours"))
            ];
        }
        
        // Insert data
        $builder = $this->db->table('pendaftaran');
        
        if ($builder->insertBatch($data)) {
            echo "Berhasil menambahkan " . count($data) . " data pendaftaran\n";
        } else {
            echo "Gagal menambahkan data pendaftaran\n";
        }
    }
}
