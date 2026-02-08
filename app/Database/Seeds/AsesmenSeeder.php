<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class AsesmenSeeder extends Seeder
{
    public function run()
    {
        // Get kunjungan IDs
        $db = \Config\Database::connect();
        $kunjunganIds = $db->table('kunjungan')->select('id')->get()->getResultArray();
        
        if (empty($kunjunganIds)) {
            echo "Tidak ada data kunjungan. Jalankan seeder kunjungan terlebih dahulu.\n";
            return;
        }
        
        $keluhanUtama = [
            'Demam tinggi sejak 3 hari yang lalu, disertai batuk dan pilek',
            'Nyeri perut bagian kanan bawah, mual dan muntah',
            'Sesak napas, dada terasa berat, terutama saat beraktivitas',
            'Sakit kepala hebat, pusing berputar, penglihatan kabur',
            'Nyeri sendi pada lutut dan pergelangan tangan',
            'Diare lebih dari 5 kali sehari, perut mulas',
            'Batuk berdahak lebih dari 2 minggu, badan lemas',
            'Gatal-gatal di seluruh tubuh, muncul bentol merah',
            'Nyeri dada sebelah kiri, sesak napas ringan',
            'Luka di kaki tidak kunjung sembuh, bernanah',
            'Mata merah, berair, gatal dan perih',
            'Telinga berdenging, pendengaran berkurang',
            'Sakit gigi berlubang, bengkak pada gusi',
            'Kencing terasa sakit dan panas',
            'Benjolan di leher, terasa nyeri saat ditekan'
        ];
        
        $keluhanTambahan = [
            'Nafsu makan menurun, badan terasa lemas',
            'Sulit tidur di malam hari',
            'Berat badan turun drastis dalam 1 bulan terakhir',
            'Sering merasa lelah meskipun tidak beraktivitas berat',
            'Kadang disertai mual dan muntah',
            null, // Some records without additional complaints
            'Riwayat penyakit diabetes',
            'Riwayat hipertensi dalam keluarga',
            null,
            'Alergi terhadap obat penisilin',
            'Pernah dirawat dengan keluhan serupa 6 bulan lalu',
            null,
            'Konsumsi obat warung tidak membaik',
            'Keluhan memberat saat cuaca dingin',
            null
        ];
        
        $data = [];
        
        // Generate asesmen untuk setiap kunjungan (max 15)
        $count = min(15, count($kunjunganIds));
        for ($i = 0; $i < $count; $i++) {
            $kunjungan = $kunjunganIds[$i];
            $randomKeluhanUtama = $keluhanUtama[array_rand($keluhanUtama)];
            $randomKeluhanTambahan = $keluhanTambahan[array_rand($keluhanTambahan)];
            
            $data[] = [
                'kunjunganid' => $kunjungan['id'],
                'keluhan_utama' => $randomKeluhanUtama,
                'keluhan_tambahan' => $randomKeluhanTambahan,
                'created_at' => date('Y-m-d H:i:s', strtotime("-" . ($i * 2) . " hours")),
                'updated_at' => date('Y-m-d H:i:s', strtotime("-" . ($i * 2) . " hours"))
            ];
        }
        
        // Insert data
        $builder = $this->db->table('asesmen');
        
        if ($builder->insertBatch($data)) {
            echo "Berhasil menambahkan " . count($data) . " data asesmen\n";
        } else {
            echo "Gagal menambahkan data asesmen\n";
        }
    }
}
