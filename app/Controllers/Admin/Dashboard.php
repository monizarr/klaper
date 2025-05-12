<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\Sekolah as ModelSekolah;
use App\Models\Siswa as ModelSiswa;
use App\Models\Kelas as ModelKelas;
use App\Models\UserApp as ModelUserApp;
use App\Models\Angkatan as ModelAngkatan;
use App\Models\Prestasi as ModelPrestasi;

class Dashboard extends BaseController
{
    protected $mAngkatan;
    protected $mKelas;
    protected $mSiswa;
    protected $mSekolah;
    protected $mPrestasi;

    public function __construct()
    {
        $this->mAngkatan = new ModelAngkatan();
        $this->mKelas = new ModelKelas();
        $this->mSiswa = new ModelSiswa();
        $this->mSekolah = new ModelSekolah();
        $this->mPrestasi = new ModelPrestasi();
    }

    public function index()
    {
        $data = [
            'title' => 'Dashboard',
            'content' => 'admin/v_index'
        ];
        // dd(session()->get('user'));
        return view('layouts/v_wrapper', $data);
    }

    public function mSekolah()
    {
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
        $sekolahs = $this->mSekolah->findAll();
        $this->mSiswa->select('siswa.*');
        $this->mSiswa->select('sekolah.nama as nama_sekolah');
        $this->mSiswa->join('sekolah', 'sekolah.id = siswa.id_sekolah');
        $dataSekolah = $this->mSiswa->findAll();

        $dataSekolah = [];
        foreach ($sekolahs as $s) {
            $jmlSiswa = $this->mSiswa->where('id_sekolah', $s['id'])->countAllResults();
            $dataSekolah[] = [
                'id' => $s['id'],
                'nama' => $s['nama'],
                'jumlah_siswa' => $jmlSiswa
            ];
        }

        $data = [
            'title' => 'Manajemen Siswa',
            'content' => 'admin/siswa/v_index',
            'apath' => 'mSiswa',
            'user' => session()->get('user'),
            'sekolah' => $dataSekolah,
        ];

        return view('layouts/v_wrapper', $data);
    }

    public function mAngkatanSekolah($id)
    {
        $sekolah = $this->mSekolah->find($id);
        $angkatan = $this->mAngkatan->where('id_sekolah', $id)->findAll();

        $countSiswa = [];
        foreach ($angkatan as $a) {
            $jmlSiswa = $this->mSiswa->where('id_sekolah', $id)->where('masuk', $a['id'])->countAllResults();
            $countSiswa[] = [
                'id' => $a['id'],
                'angkatan' => $a['angkatan'],
                'jumlah_siswa' => $jmlSiswa
            ];
        }

        $data = [
            'title' => 'Manajemen Angkatan',
            'content' => 'admin/siswa/v_angkatan',
            'apath' => 'mSiswa',
            'user' => session()->get('user'),
            'sekolah' => $sekolah,
            'angkatan' => $countSiswa
        ];

        return view('layouts/v_wrapper', $data);
    }

    public function mSiswaSekolah($idSekolah, $angkatan)
    {
        $sekolah = $this->mSekolah->find($idSekolah);
        $angkatan = $this->mAngkatan->select('angkatan.*')->where('angkatan', $angkatan)->where('id_sekolah', $idSekolah)->first();

        $this->mSiswa->select('siswa.*');
        $this->mSiswa->select('sekolah.nama as nama_sekolah');
        $this->mSiswa->join('sekolah', 'sekolah.id = siswa.id_sekolah');
        $this->mSiswa->where('siswa.masuk', $angkatan['id']);
        $this->mSiswa->where('siswa.id_sekolah', $idSekolah);
        $dataSiswa = $this->mSiswa->findAll();

        $data = [
            'title' => 'Manajemen Siswa',
            'content' => 'admin/siswa/v_tahun',
            'apath' => 'mSiswa',
            'user' => session()->get('user'),
            'sekolah' => $sekolah,
            'angkatan' => $angkatan,
            'siswa' => $dataSiswa
        ];

        return view('layouts/v_wrapper', $data);
    }

    public function mSiswaKelas($idSekolah, $angkatan, $kelas)
    {
        $sekolah = $this->mSekolah->find($idSekolah);
        $angkatan = $this->mAngkatan->select('angkatan.*')->where('angkatan', $angkatan)->where('id_sekolah', $idSekolah)->first();

        $this->mSiswa->select('siswa.*');
        $this->mSiswa->select('sekolah.nama as nama_sekolah');
        $this->mSiswa->join('sekolah', 'sekolah.id = siswa.id_sekolah');
        $this->mSiswa->where('siswa.masuk', $angkatan['id']);
        $this->mSiswa->where('siswa.id_sekolah', $idSekolah);
        $dataSiswa = $this->mSiswa->findAll();

        $data = [
            'title' => 'Manajemen Siswa',
            'content' => 'admin/siswa/v_kelas',
            'apath' => 'mSiswa',
            'user' => session()->get('user'),
            'sekolah' => $sekolah,
            'angkatan' => $angkatan,
            'siswa' => $dataSiswa
        ];

        return view('layouts/v_wrapper', $data);
    }

    public function mPrestasi()
    {
        $sekolahs = $this->mSekolah->findAll();
        $this->mSiswa->select('siswa.*');
        $this->mSiswa->select('sekolah.nama as nama_sekolah');
        $this->mSiswa->join('sekolah', 'sekolah.id = siswa.id_sekolah');
        $dataSekolah = $this->mSiswa->findAll();

        $dataSekolah = [];
        foreach ($sekolahs as $s) {
            $jmlSiswa = $this->mPrestasi->where('id_sekolah', $s['id'])->countAllResults();
            $dataSekolah[] = [
                'id' => $s['id'],
                'nama' => $s['nama'],
                'jumlah_siswa' => $jmlSiswa
            ];
        }

        $data = [
            'title' => 'Prestasi Siswa',
            'content' => 'admin/prestasi/v_index',
            'apath' => 'mSiswa',
            'user' => session()->get('user'),
            'sekolah' => $dataSekolah,
        ];

        return view('layouts/v_wrapper', $data);
    }

    public function mPrestasiSekolah($idSekolah)
    {
        $sekolah = $this->mSekolah->find($idSekolah);
        $angkatan = $this->mAngkatan->select('angkatan.*')->where('id_sekolah', $idSekolah)->distinct()->orderBy('angkatan', 'DESC')->findAll();
        $countPrestasi = [];
        foreach ($angkatan as $a) {
            $mPrestasi = $this->mPrestasi->builder();
            $mPrestasi->where('id_sekolah', $idSekolah);
            $mPrestasi->where('tanggal_prestasi >=', $a['angkatan'] . '-01-01');
            $mPrestasi->where('tanggal_prestasi <=', $a['angkatan'] . '-12-31');

            $jmlPrestasi = $mPrestasi->countAllResults();

            $countPrestasi[] = [
                'id' => $a['id'],
                'angkatan' => $a['angkatan'],
                'jumlah_prestasi' => $jmlPrestasi
            ];
        }

        $data = [
            'title' => 'Manajemen Angkatan',
            'content' => 'admin/prestasi/v_kelas',
            'apath' => 'mSiswa',
            'user' => session()->get('user'),
            'sekolah' => $sekolah,
            'angkatan' => $countPrestasi
        ];

        return view('layouts/v_wrapper', $data);
    }

    public function mPrestasiSekolahAngkatan($idSekolah, $angkatan)
    {
        $sekolah = $this->mSekolah->find($idSekolah);
        $angkatan = $this->mAngkatan->select('angkatan.*')->where('id_sekolah', $idSekolah)->where('angkatan', $angkatan)->first();

        $prestasi = $this->mPrestasi->builder();
        $prestasi->select('prestasi.*, siswa.nama as nama_siswa, siswa.nis, siswa.jk, siswa.masuk');
        $prestasi->join('siswa', 'siswa.id = prestasi.id_siswa');
        $prestasi->where('prestasi.id_sekolah', $idSekolah);
        if ($angkatan != null) {
            $prestasi->where('prestasi.tanggal_prestasi >=', $angkatan['angkatan'] . '-01-01');
            $prestasi->where('prestasi.tanggal_prestasi <=', $angkatan['angkatan'] . '-12-31');
        }
        $prestasi->orderBy('siswa.nama', 'ASC');
        $dataPrestasi = $prestasi->get()->getResultArray();

        $data = [
            'title' => 'Manajemen Siswa',
            'content' => 'admin/prestasi/v_angkatan',
            'apath' => 'mSiswa',
            'user' => session()->get('user'),
            'sekolah' => $sekolah,
            'angkatan' => $angkatan,
            'prestasi' => $dataPrestasi
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
