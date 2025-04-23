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
                'status' => 0,
                'deskripsi' => 'Angkatan 2020',
                'id_sekolah' => '1',
            ],
            [
                'angkatan' => 2021,
                'status' => 0,
                'deskripsi' => 'Angkatan 2021',
                'id_sekolah' => '1',
            ],
            [
                'angkatan' => 2022,
                'status' => 1,
                'deskripsi' => 'Angkatan 2022',
                'id_sekolah' => '1',
            ],
            [
                'angkatan' => 2020,
                'status' => 0,
                'deskripsi' => 'Angkatan 2020',
                'id_sekolah' => '2',
            ],
            [
                'angkatan' => 2021,
                'status' => 0,
                'deskripsi' => 'Angkatan 2021',
                'id_sekolah' => '2',
            ],
            [
                'angkatan' => 2022,
                'status' => 1,
                'deskripsi' => 'Angkatan 2022',
                'id_sekolah' => '2',
            ],
        ];

        $this->db->table('angkatan')->insertBatch($data);
    }
}
