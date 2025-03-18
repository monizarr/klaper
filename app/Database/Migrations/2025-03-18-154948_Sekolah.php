<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;
use App\Database\Seeds\Sekolah as SekolahSeeder;

class Sekolah extends Migration
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
            'username' => [
                'type' => 'VARCHAR',
                'constraint' => 100,
            ],
            'password' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
            ],
            'nama' => [
                'type' => 'VARCHAR',
                'constraint' => 100,
            ],
            'alamat' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
            ],
            'telp' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => true
            ],
            'email' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => true
            ],
            'kepsek' => [
                'type' => 'VARCHAR',
                'constraint' => 100,
            ],
            'akreditasi' => [
                'type' => 'ENUM',
                'constraint' => ['A', 'B', 'C', 'Tidak Terakreditasi'],
                'default' => 'Tidak Terakreditasi'
            ],
            'npsn' => [
                'type' => 'VARCHAR',
                'constraint' => 100,
            ],
            'status' => [
                'type' => 'ENUM',
                'constraint' => ['a', 'n'],
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
        $this->forge->createTable('sekolah');

        $seeder = \Config\Database::seeder();
        $seeder->call(SekolahSeeder::class);
    }

    public function down()
    {
        $this->forge->dropTable('sekolah');
    }
}
