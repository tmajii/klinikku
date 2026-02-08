<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateRolesTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'auto_increment' => true,
            ],
            'role_name' => [
                'type' => 'VARCHAR',
                'constraint' => 50,
                'unique' => true,
            ],
            'description' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => true,
            ],
            'created_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
            'updated_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('roles');

        // Insert default roles
        $data = [
            ['role_name' => 'admin', 'description' => 'Administrator', 'created_at' => date('Y-m-d H:i:s')],
            ['role_name' => 'dokter', 'description' => 'Dokter', 'created_at' => date('Y-m-d H:i:s')],
            ['role_name' => 'perawat', 'description' => 'Perawat', 'created_at' => date('Y-m-d H:i:s')],
            ['role_name' => 'staff', 'description' => 'Staff Administrasi', 'created_at' => date('Y-m-d H:i:s')],
        ];
        $this->db->table('roles')->insertBatch($data);
    }

    public function down()
    {
        $this->forge->dropTable('roles');
    }
}
