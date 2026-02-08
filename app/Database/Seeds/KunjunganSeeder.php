<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class KunjunganSeeder extends Seeder
{
    public function run()
    {
        // Get pendaftaran IDs
        $db = \Config\Database::connect();
        $pendaftaranIds = $db->table('pendaftaran')->select('id')->get()->getResultArray();
        
        if (empty($pendaftaranIds)) {
            echo "Tidak ada data pendaftaran. Jalankan seeder pendaftaran terlebih dahulu.\n";
            return;
        }
        
        $jenisKunjungan = ['Rawat Jalan', 'Rawat Inap', 'IGD', 'Kontrol', 'Konsultasi'];
        $data = [];
        $today = date('Y-m-d');
        
        // Generate 20 kunjungan dengan tanggal bervariasi
        for ($i = 1; $i <= 20; $i++) {
            // Random pendaftaran
            $randomPendaftaran = $pendaftaranIds[array_rand($pendaftaranIds)];
            
            // Random jenis kunjungan
            $randomJenis = $jenisKunjungan[array_rand($jenisKunjungan)];
            
            // Random date (10 hari ke belakang sampai 5 hari ke depan)
            $randomDays = rand(-10, 5);
            $tglKunjungan = date('Y-m-d', strtotime("$randomDays days", strtotime($today)));
            
            $data[] = [
                'pendaftaranpasienid' => $randomPendaftaran['id'],
                'jeniskunjungan' => $randomJenis,
                'tglkunjungan' => $tglKunjungan,
                'created_at' => date('Y-m-d H:i:s', strtotime("-$i hours")),
                'updated_at' => date('Y-m-d H:i:s', strtotime("-$i hours"))
            ];
        }
        
        // Insert data
        $builder = $this->db->table('kunjungan');
        
        if ($builder->insertBatch($data)) {
            echo "Berhasil menambahkan " . count($data) . " data kunjungan\n";
        } else {
            echo "Gagal menambahkan data kunjungan\n";
        }
    }
}
