<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class Prestasi extends Seeder
{
    public function run()
    {
        $data = [
            [
                'id' => 1,
                'kegiatan' => 'Juara 1 Lomba Cerdas Cermat',
                'tingkat' => 'Nasional',
                'tempat' => 'Jakarta',
                'penyelenggara' => 'Kementerian Pendidikan',
                'juara' => 'Juara 1',
                'tanggal_prestasi' => '2023-05-01',
                'sertifikat' => 'sertifikat_juara1.pdf',
                'id_siswa' => 1,
                'id_sekolah' => 1,
                'deskripsi' => 'Lomba Cerdas Cermat tingkat nasional di Jakarta',
            ],
            [
                'id' => 2,
                'kegiatan' => 'Juara 2 Lomba Matematika',
                'tingkat' => 'Provinsi',
                'tempat' => 'Bandung',
                'penyelenggara' => 'Dinas Pendidikan Provinsi',
                'juara' => 'Juara 2',
                'tanggal_prestasi' => '2023-06-15',
                'sertifikat' => 'sertifikat_juara2.pdf',
                'id_siswa' => 2,
                'id_sekolah' => 1,
                'deskripsi' => 'Lomba Matematika tingkat provinsi di Bandung',
            ],
            [
                'id' => 3,
                'kegiatan' => 'Juara Harapan 1 Lomba Sains',
                'tingkat' => 'Kabupaten',
                'tempat' => 'Bogor',
                'penyelenggara' => 'Dinas Pendidikan Kabupaten',
                'juara' => 'Juara Harapan 1',
                'tanggal_prestasi' => '2023-07-20',
                'sertifikat' => 'sertifikat_harapan1.pdf',
                'id_siswa' => 3,
                'id_sekolah' => 1,
                'deskripsi' => 'Lomba Sains tingkat kabupaten di Bogor',
            ],
        ];

        // Using Query Builder
        $this->db->table('prestasi')->insertBatch($data);
    }
}
