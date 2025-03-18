<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;
use App\Database\Seeds\Kelas as KelasSeeder;

class Kelas extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type' => 'INT',
                'constraint' => 5,
                'unsigned' => true,
                'auto_increment' => true
            ],
            'id_siswa' => [
                'type' => 'INT',
                'constraint' => 5,
                'unsigned' => true
            ],
            'id_sekolah' => [
                'type' => 'INT',
                'constraint' => 5,
                'unsigned' => true
            ],
            'kelas' => [
                'type' => 'VARCHAR',
                'constraint' => 10,
            ],
            'ta' => [
                'type' => 'YEAR',
            ],
            'created_at' => [
                'type' => 'DATETIME',
                'null' => true
            ],
            'updated_at' => [
                'type' => 'DATETIME',
                'null' => true
            ]
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addForeignKey('id_siswa', 'siswa', 'id', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('id_sekolah', 'sekolah', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('kelas');

        $seeder = \Config\Database::seeder();
        $seeder->call(KelasSeeder::class);
    }

    public function down()
    {
        $this->forge->dropTable('kelas');
    }
}
