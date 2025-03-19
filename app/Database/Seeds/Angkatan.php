<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class Angkatan extends Seeder
{
    public function run()
    {
        $data = [
            [
                'angkatan' => 2020,
                'deskripsi' => 'Angkatan 2020'
            ],
            [
                'angkatan' => 2021,
                'deskripsi' => 'Angkatan 2021'
            ],
            [
                'angkatan' => 2022,
                'deskripsi' => 'Angkatan 2022'
            ],
        ];

        $this->db->table('angkatan')->insertBatch($data);
    }
}
