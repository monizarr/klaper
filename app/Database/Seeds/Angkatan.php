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
                'deskripsi' => 'Angkatan 2020',
                'id_sekolah' => '1',
            ],
            [
                'angkatan' => 2021,
                'deskripsi' => 'Angkatan 2021',
                'id_sekolah' => '1',
            ],
            [
                'angkatan' => 2022,
                'deskripsi' => 'Angkatan 2022',
                'id_sekolah' => '1',
            ],
        ];

        $this->db->table('angkatan')->insertBatch($data);
    }
}
