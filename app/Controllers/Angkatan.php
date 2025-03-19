<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;

class Angkatan extends BaseController
{
    public function index()
    {
        $modelAngkatan = new \App\Models\Angkatan();
        $data = $modelAngkatan->findAll();
        return $this->response->setJSON($data);
    }

    public function add()
    {
        $modelAngkatan = new \App\Models\Angkatan();
        $data = [
            'angkatan' => $this->request->getPost('angkatan'),
            'deskripsi' => $this->request->getPost('deskripsi')
        ];

        $modelAngkatan->insert($data);
        session()->setFlashdata('success', 'Data angkatan berhasil ditambahkan');
        return redirect()->back();
    }
}
