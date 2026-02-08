<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateAsesmenTable extends Migration
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
            'kunjunganid' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
            ],
            'keluhan_utama' => [
                'type' => 'TEXT',
            ],
            'keluhan_tambahan' => [
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
        $this->forge->addForeignKey('kunjunganid', 'kunjungan', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('asesmen');
    }

    public function down()
    {
        $this->forge->dropTable('asesmen');
    }
}
