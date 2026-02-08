<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateKunjunganTable extends Migration
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
            'pendaftaranpasienid' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
            ],
            'jeniskunjungan' => [
                'type' => 'VARCHAR',
                'constraint' => 100,
            ],
            'tglkunjungan' => [
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
        $this->forge->addForeignKey('pendaftaranpasienid', 'pendaftaran', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('kunjungan');
    }

    public function down()
    {
        $this->forge->dropTable('kunjungan');
    }
}
