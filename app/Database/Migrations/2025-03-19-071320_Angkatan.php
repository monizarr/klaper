<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;
use App\Database\Seeds\Angkatan as AngkatanSeeder;

class Angkatan extends Migration
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
            'angkatan' => [
                'type' => 'INT',
                'constraint' => 4,
            ],
            'deskripsi' => [
                'type' => 'TEXT',
                'null' => true,
            ],
        ]);

        $this->forge->addKey('id', true);
        $this->forge->createTable('angkatan');
    }

    public function down()
    {
        $this->forge->dropTable('angkatan');
    }
}
