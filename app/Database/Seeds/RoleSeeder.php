<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class RoleSeeder extends Seeder
{
    public function run()
    {
        $data = [
            [
                'id' => 1,
                'role_name' => 'Superadmin',
                'description' => 'Akses penuh ke semua fitur sistem',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            [
                'id' => 2,
                'role_name' => 'Admisi',
                'description' => 'Hanya bisa CRUD Pendaftaran dan Kunjungan, tidak bisa akses Data Pasien dan Asesmen',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            [
                'id' => 3,
                'role_name' => 'Perawat',
                'description' => 'View only Pendaftaran dan Kunjungan, CRUD Asesmen dan Diagnosa, tidak bisa akses Data Pasien',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ]
        ];

        $this->db->table('roles')->insertBatch($data);
        echo "Role data berhasil ditambahkan!\n";
    }
}
