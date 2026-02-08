<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class TestDataSeeder extends Seeder
{
    public function run()
    {
        // Insert Roles first
        $this->call('RoleSeeder');
        
        // Insert Users
        $this->call('UserSeeder');
        
        // Insert Pasien
        $pasienData = [
            ['nama' => 'Budi Santoso', 'norm' => 'RM001', 'alamat' => 'Jl. Merdeka No. 10, Jakarta', 'created_at' => date('Y-m-d H:i:s')],
            ['nama' => 'Siti Nurhaliza', 'norm' => 'RM002', 'alamat' => 'Jl. Sudirman No. 25, Bandung', 'created_at' => date('Y-m-d H:i:s')],
            ['nama' => 'Ahmad Fauzi', 'norm' => 'RM003', 'alamat' => 'Jl. Gatot Subroto No. 15, Surabaya', 'created_at' => date('Y-m-d H:i:s')],
        ];
        $this->db->table('pasien')->insertBatch($pasienData);

        // Insert Pendaftaran
        $pendaftaranData = [
            ['pasienid' => 1, 'noregistrasi' => 'REG20260208001', 'tglregistrasi' => '2026-02-08', 'created_at' => date('Y-m-d H:i:s')],
            ['pasienid' => 2, 'noregistrasi' => 'REG20260208002', 'tglregistrasi' => '2026-02-08', 'created_at' => date('Y-m-d H:i:s')],
            ['pasienid' => 3, 'noregistrasi' => 'REG20260208003', 'tglregistrasi' => '2026-02-08', 'created_at' => date('Y-m-d H:i:s')],
        ];
        $this->db->table('pendaftaran')->insertBatch($pendaftaranData);

        // Insert Kunjungan
        $kunjunganData = [
            ['pendaftaranpasienid' => 1, 'jeniskunjungan' => 'Rawat Jalan', 'tglkunjungan' => '2026-02-08', 'created_at' => date('Y-m-d H:i:s')],
            ['pendaftaranpasienid' => 2, 'jeniskunjungan' => 'Rawat Inap', 'tglkunjungan' => '2026-02-08', 'created_at' => date('Y-m-d H:i:s')],
            ['pendaftaranpasienid' => 3, 'jeniskunjungan' => 'IGD', 'tglkunjungan' => '2026-02-08', 'created_at' => date('Y-m-d H:i:s')],
        ];
        $this->db->table('kunjungan')->insertBatch($kunjunganData);

        // Insert Asesmen
        $asesmenData = [
            ['kunjunganid' => 1, 'keluhan_utama' => 'Demam tinggi sejak 3 hari yang lalu', 'keluhan_tambahan' => 'Sakit kepala dan mual', 'created_at' => date('Y-m-d H:i:s')],
            ['kunjunganid' => 2, 'keluhan_utama' => 'Nyeri dada dan sesak napas', 'keluhan_tambahan' => 'Batuk berdahak', 'created_at' => date('Y-m-d H:i:s')],
            ['kunjunganid' => 3, 'keluhan_utama' => 'Kecelakaan lalu lintas, luka di kepala', 'keluhan_tambahan' => 'Pusing dan mual', 'created_at' => date('Y-m-d H:i:s')],
        ];
        $this->db->table('asesmen')->insertBatch($asesmenData);

        // Insert Diagnosa
        $diagnosaData = [
            ['asesmenid' => 1, 'kode_icd' => 'A90', 'nama_diagnosa' => 'Demam Berdarah Dengue', 'jenis_diagnosa' => 'primer', 'keterangan' => 'Trombosit rendah', 'created_at' => date('Y-m-d H:i:s')],
            ['asesmenid' => 2, 'kode_icd' => 'I20.0', 'nama_diagnosa' => 'Angina Pektoris', 'jenis_diagnosa' => 'primer', 'keterangan' => 'Perlu pemeriksaan EKG lanjutan', 'created_at' => date('Y-m-d H:i:s')],
            ['asesmenid' => 3, 'kode_icd' => 'S06.0', 'nama_diagnosa' => 'Cedera Kepala Ringan', 'jenis_diagnosa' => 'primer', 'keterangan' => 'Observasi 24 jam', 'created_at' => date('Y-m-d H:i:s')],
        ];
        $this->db->table('diagnosa')->insertBatch($diagnosaData);

        echo "Data dummy berhasil ditambahkan!\n";
    }
}
