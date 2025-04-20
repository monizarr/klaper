<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;
use App\Database\Seeds\Prestasi as PrestasiSeeder;

class Prestasi extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type' => 'INT',
                'constraint' => 11,
                'auto_increment' => true,
            ],
            'kegiatan' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
            ],
            'tingkat' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
            ],
            'tempat' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
            ],
            'penyelenggara' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
            ],
            'juara' => [
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
            'id_siswa' => [
                'type' => 'INT',
                'constraint' => 11,
            ],
            'id_sekolah' => [
                'type' => 'INT',
                'constraint' => 11,
            ],
        ]);

        $this->forge->addKey('id', true);
        $this->forge->createTable('prestasi');
        $this->forge->addForeignKey('id_siswa', 'siswa', 'id', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('id_sekolah', 'sekolah', 'id', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('sertifikat', 'file', 'id', 'CASCADE', 'CASCADE');

        $seeder = \Config\Database::seeder();
        $seeder->call(PrestasiSeeder::class);
    }

    public function down()
    {
        $this->forge->dropTable('prestasi');
    }
}
