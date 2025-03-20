<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Prestasi extends Migration
{
    public function up()
    {
        // id, prestasi, deskripsi_prestasi, tanggal_prestasi, sertifikat
        $this->forge->addField([
            'id' => [
                'type' => 'INT',
                'constraint' => 11,
                'auto_increment' => true,
            ],
            'prestasi' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
            ],
            'tingkat' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
            ],
            'deskripsi' => [
                'type' => 'TEXT',
            ],
            'tanggal_prestasi' => [
                'type' => 'DATE',
            ],
            'sertifikat' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
            ],
        ]);

        $this->forge->addKey('id', true);
        $this->forge->createTable('prestasi');
    }

    public function down()
    {
        $this->forge->dropTable('prestasi');
    }
}
