<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class Kelas extends Seeder
{
    public function run()
    {
        $data = [
            [
                'id_siswa' => 1,
                'id_sekolah' => 1,
                'kelas' => '1',
                'ta' => '1',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            [
                'id_siswa' => 2,
                'id_sekolah' => 1,
                'kelas' => '1',
                'ta' => '1',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            [
                'id_siswa' => 3,
                'id_sekolah' => 2,
                'kelas' => '1',
                'ta' => '1',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            [
                'id_siswa' => 4,
                'id_sekolah' => 2,
                'kelas' => '1',
                'ta' => '3',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ]
        ];

        $this->db->table('kelas')->insertBatch($data);
    }
}
