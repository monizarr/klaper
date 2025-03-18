<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class Sekolah extends Seeder
{
    public function run()
    {
        $data = [
            [
                'nama' => 'SDN 1',
                'username' => 'sdn1',
                'password' => password_hash('sdn1', PASSWORD_DEFAULT),
                'alamat' => 'Jl. Raya 1',
                'telp' => '021-123456',
                'email' => 'sdn1@gmail.com',
                'kepsek' => 'Pak SDN 1',
                'akreditasi' => 'A',
                'npsn' => '12345678',
                'created_at' => date('Y-m-d H:i:s')
            ],
            [
                'nama' => 'SDN 2',
                'username' => 'sdn2',
                'password' => password_hash('sdn2', PASSWORD_DEFAULT),
                'alamat' => 'Jl. Raya 2',
                'telp' => '021-123457',
                'email' => 'sdn2@gmail.com',
                'kepsek' => 'Pak SDN 2',
                'akreditasi' => 'B',
                'npsn' => '12345679',
                'created_at' => date('Y-m-d H:i:s')
            ],
        ];

        $this->db->table('sekolah')->insertBatch($data);
    }
}
