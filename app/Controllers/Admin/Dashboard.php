<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\Sekolah as ModelSekolah;
use App\Models\Siswa as ModelSiswa;
use App\Models\Kelas as ModelKelas;
use App\Models\UserApp as ModelUserApp;

class Dashboard extends BaseController
{

    public function index()
    {
        if (session()->get('user') == null) {
            return redirect()->to('/admin/login');
        }

        $data = [
            'title' => 'Dashboard',
            'content' => 'adminapp/v_index'
        ];
        return view('layouts/v_wrapper', $data);
    }

    public function mSekolah()
    {
        if (session()->get('user') == null) {
            return redirect()->to('/admin/login');
        }

        $mSekolah = new ModelSekolah();

        $encrypter = \Config\Services::encrypter();

        $sekolahs = $mSekolah->findAll();
        // decrypt password_hash
        // foreach ($sekolahs as $key => $value) {
        //     $sekolahs[$key]['password'] = $encrypter->decrypt(base64_decode($value['password']));
        // }

        // dd($sekolahs);

        $data = [
            'title' => 'Manajemen Sekolah',
            'content' => 'adminapp/v_msekolah',
            'apath' => 'mSekolah',
            'user' => session()->get('user'),
            'sekolah' => $sekolahs
        ];
        return view('layouts/v_wrapper', $data);
    }

    public function addSekolah()
    {
        $nama = $this->request->getPost('nama');
        $username = $this->request->getPost('username');
        $password = $this->request->getPost('password');
        $alamat = $this->request->getPost('alamat');
        $email = $this->request->getPost('email');
        $telp = $this->request->getPost('telp');
        $kepsek = $this->request->getPost('kepsek');
        $akreditasi = $this->request->getPost('akreditasi');

        $mSekolah = new ModelSekolah();
        $mSekolah->insert([
            'nama' => $nama,
            'username' => $username,
            'password' => password_hash($password, PASSWORD_DEFAULT),
            'email' => $email,
            'alamat' => $alamat,
            'telp' => $telp,
            'kepsek' => $kepsek,
            'akreditasi' => $akreditasi,
            'created_at' => date('Y-m-d H:i:s')
        ]);

        session()->setFlashdata('success', 'Data sekolah berhasil ditambahkan');
        return redirect()->to('/admin/sekolah');
    }

    public function mSiswa()
    {
        if (session()->get('user') == null) {
            return redirect()->to('/admin/login');
        }
        $mSiswa = new ModelSiswa();
        $mSekolah = new ModelSekolah();
        $tahun = $mSiswa->select('masuk')->distinct()->findAll();
        $sekolahs = $mSekolah->findAll();
        // siswa join sekolah
        $mSiswa->select('siswa.*');
        $mSiswa->select('sekolah.nama as nama_sekolah');
        $mSiswa->join('sekolah', 'sekolah.id = siswa.id_sekolah');

        $data = [
            'title' => 'Manajemen Siswa',
            'content' => 'adminapp/v_msiswa',
            'apath' => 'mSiswa',
            'user' => session()->get('user'),
            'angkatan' => $tahun,
            'sekolah' => $sekolahs,
            'siswa' => $mSiswa->findAll()
        ];
        return view('layouts/v_wrapper', $data);
    }

    public function getSiswa()
    {
        $model = new ModelSiswa();

        // Ambil parameter dari request DataTables
        $start = $this->request->getVar('start');
        $length = $this->request->getVar('length');
        $draw = $this->request->getVar('draw');
        $searchValue = $this->request->getVar('search')['value'] ?? '';
        $angkatan = $this->request->getGet('angkatan'); // Ambil parameter angkatan dari request
        $namaSekolah = $this->request->getGet('nama_sekolah'); // Ambil parameter id_sekolah dari request
        $orderColumn = $this->request->getVar('order')[0]['column'];

        // Query builder
        $builder = $model->builder();

        // siswa join sekolah
        $builder->select('siswa.*');
        $builder->select('sekolah.nama as nama_sekolah');
        $builder->join('sekolah', 'sekolah.id = siswa.id_sekolah');

        // Filter berdasarkan angkatan jika ada
        // if (!empty($angkatan)) {
        //     $builder->where('masuk', $angkatan);
        // }
        if (!empty($namaSekolah)) {
            $builder->where('sekolah.nama', $namaSekolah);
        }

        // Filter pencarian jika ada
        if (!empty($searchValue)) {
            $builder->like('siswa.nama', $searchValue);
        }

        // Hitung total record sebelum limit
        $totalRecords = $builder->countAllResults(false);

        // order by
        if ($orderColumn == 1) {
            $builder->orderBy('nama',   $this->request->getVar('order')[0]['dir']);
        } else if ($orderColumn == 2) {
            $builder->orderBy('jk', $this->request->getVar('order')[0]['dir']);
        } else if ($orderColumn == 3) {
            $builder->orderBy('nama_sekolah', $this->request->getVar('order')[0]['dir']);
        } else if ($orderColumn == 4) {
            $builder->orderBy('masuk', $this->request->getVar('order')[0]['dir']);
        }

        // Ambil data dengan limit dan offset
        $data = $builder->limit($length, $start)->get()->getResult();

        // Hitung total record yang sesuai filter pencarian
        $totalFilteredRecords = count($data);

        // Format data untuk DataTables
        $response = [
            'draw' => intval($draw),
            'recordsTotal' => $totalRecords,
            'recordsFiltered' => $totalFilteredRecords,
            'data' => $data
        ];

        return $this->response->setJSON($response);
    }

    public function getSekolah()
    {
        $model = new ModelSekolah();

        // Ambil parameter dari request DataTables
        $start = $this->request->getVar('start');
        $length = $this->request->getVar('length');
        $draw = $this->request->getVar('draw');
        $searchValue = $this->request->getVar('search')['value'] ?? '';

        // Query builder
        $builder = $model->builder();

        // Filter pencarian jika ada
        if (!empty($searchValue)) {
            $builder->like('nama', $searchValue); // Misalnya pencarian berdasarkan nama
        }

        // Hitung total record sebelum limit
        $totalRecords = $builder->countAllResults(false);

        // Ambil data dengan limit dan offset
        $data = $builder->limit($length, $start)->get()->getResult();

        // Hitung total record yang sesuai filter pencarian
        $totalFilteredRecords = count($data);

        // Format data untuk DataTables
        $response = [
            'draw' => intval($draw),
            'recordsTotal' => $totalRecords,
            'recordsFiltered' => $totalFilteredRecords,
            'data' => $data
        ];

        return $this->response->setJSON($response);
    }


    public function editSekolah()
    {
        $id = $this->request->getPost('id');

        $data = [
            'nama' => $this->request->getPost('nama'),
            'username' => $this->request->getPost('username'),
            'password' => password_hash($this->request->getPost('password'), PASSWORD_DEFAULT),
            'alamat' => $this->request->getPost('alamat'),
            'telp' => $this->request->getPost('telp'),
            'email' => $this->request->getPost('email'),
            'kepsek' => $this->request->getPost('kepsek'),
            'akreditasi' => $this->request->getPost('akreditasi'),
            'updated_at' => date('Y-m-d H:i:s')
        ];

        if ($this->request->getPost('password') == '') {
            unset($data['password']);
        }

        $mSekolah = new ModelSekolah();
        $mSekolah->update($id, $data);

        session()->setFlashdata('success', 'Data sekolah berhasil diubah');
        return redirect()->to('/admin/sekolah');
    }

    public function deleteSekolah($id)
    {

        $mSekolah = new ModelSekolah();
        $sttNow = $mSekolah->find($id)['status'];

        $data = [];

        if ($sttNow == 'n') {
            $data = [
                'status' => 'a',
                'updated_at' => date('Y-m-d H:i:s')
            ];
        } else {
            $data = [
                'status' => 'n',
                'updated_at' => date('Y-m-d H:i:s')
            ];
        }

        $mSekolah->update($id, $data);

        session()->setFlashdata('success', 'Data sekolah berhasil diperbarui');
        return redirect()->to('/admin/sekolah');
    }

    public function profil()
    {
        $mAdmin = new ModelUserapp();
        $user = $mAdmin->find(session()->get('user')['id']);
        $data = [
            'title' => 'Profil',
            'content' => 'adminapp/v_profil',
            'user' => $user
        ];

        return view('layouts/v_wrapper', $data);
    }

    public function updateProfileAdminApp()
    {
        $id = $this->request->getPost('id');

        $data = [
            'username' => $this->request->getPost('username'),
            'password' => password_hash($this->request->getPost('password'), PASSWORD_DEFAULT),
            'email' => $this->request->getPost('email'),
            'updated_at' => date('Y-m-d H:i:s')
        ];

        if ($this->request->getPost('password') == '') {
            unset($data['password']);
        }

        $mAdmin = new ModelUserapp();
        $mAdmin->update($id, $data);

        session()->setFlashdata('success', 'Data admin berhasil diubah');
        return redirect()->to('/admin/profil');
    }
}
