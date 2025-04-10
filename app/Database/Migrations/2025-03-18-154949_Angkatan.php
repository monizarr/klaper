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
            'status' => [
                'type' => 'BOOLEAN',
                'default' => 0,
            ],
            'deskripsi' => [
                'type' => 'TEXT',
                'null' => true,
            ],
            'id_sekolah' => [
                'type' => 'INT',
                'constraint' => 5,
                'unsigned' => true,
            ],
        ]);

        $this->forge->addKey('id', true);
        $this->forge->createTable('angkatan');
        $this->forge->addForeignKey('id_sekolah', 'sekolah', 'id', 'CASCADE', 'CASCADE');

        $seeder = \Config\Database::seeder();
        $seeder->call(AngkatanSeeder::class);
    }

    public function down()
    {
        $this->forge->dropTable('angkatan');
    }
}
