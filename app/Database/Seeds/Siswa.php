<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class Siswa extends Seeder
{
    public function run()
    {
        $data = [
            [
                'id_sekolah' => 1,
                'status_masuk' => 'ppdb',
                'status_keluar' => null,
                'nis' => '1234567890',
                'nama' => 'Siswa 1',
                'tempat_lahir' => 'Jakarta',
                'tgl_lahir' => '2010-01-01',
                'jk'    => 'L',
                'orang_tua' => 'Ayah 1',
                'masuk' => '1',
                'keluar' => null,
                'bukti_masuk' => null,
                'bukti_keluar' => null,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            [
                'id_sekolah' => 1,
                'status_masuk' => 'ppdb',
                'status_keluar' => null,
                'nis' => '1234567891',
                'nama' => 'Siswa 2',
                'tempat_lahir' => 'Jakarta',
                'tgl_lahir' => '2010-01-01',
                'jk'    => 'P',
                'orang_tua' => 'Ibu 2',
                'masuk' => '1',
                'keluar' => null,
                'bukti_masuk' => null,
                'bukti_keluar' => null,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            [
                'id_sekolah' => 2,
                'status_masuk' => 'ppdb',
                'status_keluar' => null,
                'nis' => '1234567892',
                'nama' => 'Siswa 3',
                'tempat_lahir' => 'Jakarta',
                'tgl_lahir' => '2010-01-01',
                'jk'    => 'L',
                'orang_tua' => 'Ayah 3',
                'masuk' => '4',
                'keluar' => null,
                'bukti_masuk' => null,
                'bukti_keluar' => null,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            [
                'id_sekolah' => 2,
                'status_masuk' => 'ppdb',
                'status_keluar' => null,
                'nis' => '1234567893',
                'nama' => 'Siswa 4',
                'tempat_lahir' => 'Jakarta',
                'tgl_lahir' => '2010-01-01',
                'jk'    => 'P',
                'orang_tua' => 'Ibu 4',
                'masuk' => '4',
                'keluar' => null,
                'bukti_masuk' => null,
                'bukti_keluar' => null,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ]
        ];
        $this->db->table('siswa')->insertBatch($data);
    }
}
