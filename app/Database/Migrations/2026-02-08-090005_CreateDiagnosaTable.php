<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateDiagnosaTable extends Migration
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
            'asesmenid' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
            ],
            'kode_icd' => [
                'type' => 'VARCHAR',
                'constraint' => 20,
                'null' => true,
            ],
            'nama_diagnosa' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
            ],
            'jenis_diagnosa' => [
                'type' => 'ENUM',
                'constraint' => ['primer', 'sekunder'],
                'default' => 'primer',
            ],
            'keterangan' => [
                'type' => 'TEXT',
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
        $this->forge->addForeignKey('asesmenid', 'asesmen', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('diagnosa');
    }

    public function down()
    {
        $this->forge->dropTable('diagnosa');
    }
}
