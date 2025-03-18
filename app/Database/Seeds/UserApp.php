<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class UserApp extends Seeder
{
    public function run()
    {
        $data = [
            [
                'username' => 'admin',
                'email' => 'admin@email.com',
                'password' => password_hash('admin', PASSWORD_DEFAULT),
                'created_at' => date('Y-m-d H:i:s')
            ],
        ];

        $this->db->table('userapp')->insertBatch($data);
    }
}
