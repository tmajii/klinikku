<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreatePendaftaranTable extends Migration
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
            'pasienid' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
            ],
            'noregistrasi' => [
                'type' => 'VARCHAR',
                'constraint' => 50,
                'unique' => true,
            ],
            'tglregistrasi' => [
                'type' => 'DATE',
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
        $this->forge->addForeignKey('pasienid', 'pasien', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('pendaftaran');
    }

    public function down()
    {
        $this->forge->dropTable('pendaftaran');
    }
}
