<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\Kelas as ModelKelas;

class Kelas extends BaseController
{
    public function index()
    {
        //
    }

    public function add()
    {
        $data = [
            'id_siswa' => $this->request->getPost('id_siswa'),
            'id_sekolah' => $this->request->getPost('id_sekolah'),
            'kelas' => $this->request->getPost('kelas'),
            'ta' => $this->request->getPost('ta'),
            'created_at' => date('Y-m-d H:i:s')
        ];

        $mKelas = new ModelKelas();
        // cek kelas terakhir siswa
        $kelasTerakhir = $mKelas->where('id_siswa', $data['id_siswa'])->orderBy('id', 'DESC')->first();
        // limit kelas hanya sampai 6
        if ($kelasTerakhir) {
            if ($kelasTerakhir['kelas'] >= 6) {
                session()->setFlashdata('error', 'Siswa sudah mencapai kelas 6');
                return redirect()->back();
            }
        }

        $mKelas->insert($data);

        //set flashdata
        session()->setFlashdata('success', 'Data kelas berhasil ditambahkan');
        return redirect()->back();
    }


    public function update($id_kelas)
    {
        $mKelas = new ModelKelas();
        $data = $this->request->getJSON();

        $update = $mKelas->update($id_kelas, $data);

        if ($update) {
            session()->setFlashdata('success', 'Data kelas berhasil diupdate');
            return redirect()->back();
        } else {
            session()->setFlashdata('error', 'Gagal mengupdate data kelas');
            return redirect()->back();
        }
    }

    public function delete($id_kelas)
    {
        $mKelas = new ModelKelas();
        $mKelas->delete($id_kelas);

        //set flashdata
        session()->setFlashdata('success', 'Data kelas berhasil dihapus');
        return redirect()->back();
    }
}
