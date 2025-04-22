<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;

class Angkatan extends BaseController
{

    protected $mAngkatan;
    public function __construct()
    {
        $this->mAngkatan = new \App\Models\Angkatan();
    }

    public function index()
    {
        $data = $this->mAngkatan->findAll();
        return $this->response->setJSON($data);
    }

    public function add()
    {
        $data = [
            'angkatan' => $this->request->getPost('angkatan'),
            'deskripsi' => $this->request->getPost('deskripsi'),
            'id_sekolah' => $this->request->getPost('id_sekolah')
        ];
        $angkatanAktif = $this->mAngkatan->where('id_sekolah', $data['id_sekolah'])->where('status', 1)->where('angkatan', $data['angkatan'])->first();
        if ($angkatanAktif) {
            session()->setFlashdata('error', 'Angkatan sudah terdaftar');
            return redirect()->back();
        }
        // insert data angkatan
        $this->mAngkatan->insert($data);
        session()->setFlashdata('success', 'Data angkatan berhasil ditambahkan');
        return redirect()->back();
    } 

    public function updateTaActive()
    {
        $data = [
            'id' => $this->request->getPost('taAktif')
        ];

        if ($data['id'] == null) {
            session()->setFlashdata('success', 'Tidak ada perubahan tahun ajaran aktif');
            return redirect()->back();
        }


        $activedId = $this->mAngkatan->where('id_sekolah', session()->get('user')['sekolah']['id'])->where('status', 1)->first();
        if (!$activedId) {
            $this->mAngkatan->where('id', $data['id'])->update($data['id'], ['status' => 1]);
        } else {
            $this->mAngkatan->where('id', $activedId['id'])->update($activedId['id'], ['status' => 0]);
            $this->mAngkatan->where('id', $data['id'])->update($data['id'], ['status' => 1]);
        }

        session()->setFlashdata('success', 'Tahun ajaran aktif berhasil diubah');
        return redirect()->back();
    }

    public function delete($id)
    {
        $this->mAngkatan->delete($id);
        session()->setFlashdata('success', 'Data angkatan berhasil dihapus');
        return redirect()->back();
    }
}
