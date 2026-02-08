<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class UserSeeder extends Seeder
{
    public function run()
    {
        $data = [
            [
                'username' => 'superadmin',
                'email' => 'superadmin@klinik.com',
                'password' => password_hash('admin123', PASSWORD_DEFAULT),
                'full_name' => 'Super Administrator',
                'role_id' => 1,
                'is_active' => 1,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            [
                'username' => 'admisi',
                'email' => 'admisi@klinik.com',
                'password' => password_hash('admisi123', PASSWORD_DEFAULT),
                'full_name' => 'Staff Admisi',
                'role_id' => 2,
                'is_active' => 1,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            [
                'username' => 'perawat',
                'email' => 'perawat@klinik.com',
                'password' => password_hash('perawat123', PASSWORD_DEFAULT),
                'full_name' => 'Perawat Klinik',
                'role_id' => 3,
                'is_active' => 1,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ]
        ];

        $this->db->table('users')->insertBatch($data);
        echo "User data berhasil ditambahkan!\n";
    }
}
