<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;
use App\Database\Seeds\UserApp as UserAppSeeder;

class UserApp extends Migration
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
            'email' => [
                'type' => 'VARCHAR',
                'constraint' => 100,
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
        $this->forge->createTable('userapp');

        $seeder = \Config\Database::seeder();
        $seeder->call(UserAppSeeder::class);
    }

    public function down()
    {
        $this->forge->dropTable('userapp');
    }
}
