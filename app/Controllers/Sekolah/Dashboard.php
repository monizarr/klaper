<?php

namespace App\Controllers\Sekolah;

use App\Controllers\BaseController;
use App\Models\Siswa as ModelSiswa;
use App\Models\Kelas as ModelKelas;
use App\Models\Sekolah as ModelSekolah;
use App\Models\Angkatan as ModelAngkatan;
use App\Models\Prestasi;
use CodeIgniter\HTTP\ResponseInterface;

class Dashboard extends BaseController
{
    protected $mAngkatan;
    protected $mKelas;
    protected $mSiswa;
    protected $mSekolah;

    public function __construct()
    {
        $this->mAngkatan = new ModelAngkatan();
        $this->mKelas = new ModelKelas();
        $this->mSiswa = new ModelSiswa();
        $this->mSekolah = new ModelSekolah();
    }

    public function index()
    {
        $data = [
            'title' => 'Dashboard',
            'content' => 'sekolah/v_index',
            'apath' => 'homeAdmin'
        ];
        return view('layouts/v_wrapper', $data);
    }

    public function mSiswa()
    {

        $user  = session()->get('user');
        $idUser = $user['sekolah']['id'];

        $mSiswa = new ModelSiswa();
        $builder = $mSiswa->builder();
        $builder->select('siswa.*, 
        angkatan_masuk.angkatan AS masuk, 
        angkatan_keluar.angkatan AS keluar');
        $builder->join('angkatan angkatan_masuk', 'angkatan_masuk.id = siswa.masuk', 'left');
        $builder->join('angkatan angkatan_keluar', 'angkatan_keluar.id = siswa.keluar', 'left');
        $builder->where('siswa.id_sekolah', $idUser);
        $builder->orderBy('siswa.nama', 'ASC');
        $siswa = $builder->get()->getResultArray();

        $tahun = $this->mAngkatan->where('id_sekolah', $idUser)->distinct()->orderBy('angkatan', 'DESC')->findAll();

        $resTahun = [];
        foreach ($tahun as $t) {
            $jmlSiswa = $this->mSiswa->where('id_sekolah', $idUser)->where('masuk', $t['id'])->countAllResults();
            $resTahun[] = [
                'id' => $t['id'],
                'angkatan' => $t['angkatan'],
                'jumlah_siswa' => $jmlSiswa
            ];
        }

        helper(['form']);

        $data = [
            'title' => 'Manajemen Data Siswa',
            'content' => 'sekolah/siswa/v_index',
            'apath' => 'mSiswa',
            'siswa' => $siswa,
            'user' => $user,
            'angkatan' => $resTahun,
        ];

        return view('layouts/v_wrapper', $data);
    }

    public function mSiswaByAngkatan($angkatan)
    {
        $mSiswa = new ModelSiswa();
        $mAngkatan = new ModelAngkatan();

        $user  = session()->get('user');
        $ta = $mAngkatan->findAll();
        $angkatanMasuk = $mAngkatan->where('angkatan', $angkatan)->first();
        if ($angkatanMasuk) {
            $angkatan = $angkatanMasuk['id'];
        } else {
            $angkatan = null;
        }

        $builder = $mSiswa->builder();
        $builder->select('siswa.*, 
        angkatan_masuk.angkatan AS masuk, 
        angkatan_keluar.angkatan AS keluar');
        $builder->join('angkatan angkatan_masuk', 'angkatan_masuk.id = siswa.masuk', 'left');
        $builder->join('angkatan angkatan_keluar', 'angkatan_keluar.id = siswa.keluar', 'left');
        $builder->where('siswa.id_sekolah', session()->get('user')['sekolah']['id']);
        $builder->where('siswa.masuk', $angkatan);
        $builder->orderBy('siswa.nama', 'ASC');
        $siswa = $builder->get()->getResultArray();

        helper(['form']);

        $data = [
            'title' => 'Manajemen Data Siswa',
            'content' => 'sekolah/siswa/v_angkatan',
            'apath' => 'mSiswa',
            'siswa' => $siswa,
            'user' => $user,
            'ta' => $ta
        ];

        return view('layouts/v_wrapper', $data);
    }

    public function mAkademis()
    {
        $mSiswa = new ModelSiswa();
        $mAngkatan = new ModelAngkatan();

        $user  = session()->get('user');
        $siswa = $mSiswa->where('id_sekolah', $user['sekolah']['id'])->findAll();
        $tahun = $mAngkatan->where('id_sekolah', $user['sekolah']['id'])->distinct()->orderBy('angkatan', 'DESC')->findAll();

        $resTahun = [];
        foreach ($tahun as $t) {
            $jmlSiswa = $mSiswa->where('id_sekolah', $user['sekolah']['id'])->where('masuk', $t['id'])->countAllResults();
            $resTahun[] = [
                'id' => $t['id'],
                'angkatan' => $t['angkatan'],
                'jumlah_siswa' => $jmlSiswa
            ];
        }

        helper(['form']);

        $data = [
            'title' => 'Manajemen Data Akademis',
            'content' => 'sekolah/akademis/v_index',
            'apath' => 'mSiswa',
            'siswa' => $siswa,
            'user' => $user,
            'angkatan' => $resTahun
        ];

        return view('layouts/v_wrapper', $data);
    }

    public function mAkademisAngkatan($angkatan)
    {
        $mSiswa = new ModelSiswa();
        $mKelas = new ModelKelas();
        $mAngkatan = new ModelAngkatan();

        $angkatanMasuk = $mAngkatan->where('angkatan', $angkatan)->first();
        if ($angkatanMasuk) {
            $angkatanMasuk = $angkatanMasuk['id'];
        } else {
            $angkatanMasuk = null;
        }
        $user  = session()->get('user');
        $siswa = $mSiswa->where('id_sekolah', $user['sekolah']['id'])->where('masuk', $angkatanMasuk)->findAll();

        helper(['form']);

        $data = [
            'title' => 'Data Akademis Angkatan ' . $angkatan,
            'content' => 'sekolah/akademis/v_angkatan',
            'apath' => 'mSiswa',
            'user' => $user,
            'siswa' => $siswa,
            'angkatan' => $angkatan,
        ];

        return view('layouts/v_wrapper', $data);
    }

    public function mAkademisKelas($angkatan, $kelas)
    {
        $mSiswa = new ModelSiswa();
        $mKelas = new ModelKelas();
        $mAngkatan = new ModelAngkatan();

        $angkatanMasuk = $mAngkatan->where('angkatan', $angkatan)->first();
        if ($angkatanMasuk) {
            $angkatan = $angkatanMasuk['id'];
        } else {
            $angkatan = null;
        }

        $user  = session()->get('user');
        $siswa = $mSiswa->where('id_sekolah', $user['sekolah']['id'])->where('masuk', $angkatan)->findAll();

        helper(['form']);

        $data = [
            'title' => 'Data Akademis Angkatan ' . $angkatanMasuk['angkatan'] . ' Kelas ' . $kelas,
            'content' => 'sekolah/akademis/v_kelas',
            'apath' => 'mSiswa',
            'user' => $user,
            'siswa' => $siswa,
            'angkatan' => $angkatan,
        ];

        return view('layouts/v_wrapper', $data);
    }

    public function mPrestasi()
    {

        $mSiswa = new ModelSiswa();
        $mAngkatan = new ModelAngkatan();
        $mPrestasi = new Prestasi();

        $user  = session()->get('user');
        $siswa = $mSiswa->where('id_sekolah', $user['sekolah']['id'])->findAll();
        $tahun = $mAngkatan->where('id_sekolah', $user['sekolah']['id'])->distinct()->orderBy('angkatan', 'DESC')->findAll();

        $resTahun = [];
        foreach ($tahun as $t) {
            $jmlSiswa = $mPrestasi
                ->where('id_sekolah', $user['sekolah']['id'])
                ->where('tanggal_prestasi >=', $t['angkatan'] . '-01-01')
                ->where('tanggal_prestasi <=', $t['angkatan'] . '-12-31')
                ->countAllResults();

            $resTahun[] = [
                'id' => $t['id'],
                'angkatan' => $t['angkatan'],
                'jumlah_siswa' => $jmlSiswa
            ];
        }

        helper(['form']);

        $data = [
            'title' => 'Manajemen Data Prestasi',
            'content' => 'sekolah/prestasi/v_index',
            'apath' => 'mSiswa',
            'siswa' => $siswa,
            'user' => $user,
            'angkatan' => $resTahun
        ];

        return view('layouts/v_wrapper', $data);
    }

    public function mPrestasiByAngkatan($angkatan)
    {

        $mSiswa = new ModelSiswa();
        $mPrestasi = new Prestasi();

        $user  = session()->get('user');
        $tahun = $mSiswa->select('masuk')->where('id_sekolah', $user['sekolah']['id'])->distinct()->findAll();

        $prestasi = $mPrestasi->builder();
        $prestasi->select('prestasi.*, siswa.nama, siswa.nis, siswa.masuk');
        $prestasi->join('siswa', 'siswa.id = prestasi.id_siswa', 'left');
        $prestasi->where('prestasi.id_sekolah', session()->get('user')['sekolah']['id']);
        $prestasi->where('siswa.id_sekolah', session()->get('user')['sekolah']['id']);

        if ($angkatan != null) {
            $prestasi->where('prestasi.tanggal_prestasi >=', $angkatan . '-01-01');
            $prestasi->where('prestasi.tanggal_prestasi <=', $angkatan . '-12-31');
        }
        $prestasi->orderBy('siswa.nama', 'ASC');
        $prestasi = $prestasi->get()->getResultArray();

        helper(['form']);

        $data = [
            'title' => 'Manajemen Siswa',
            'content' => 'sekolah/prestasi/v_angkatan',
            'apath' => 'mSiswa',
            'prestasi' => $prestasi,
            'user' => $user,
            'angkatan' => $tahun
        ];

        return view('layouts/v_wrapper', $data);
    }


    public function getSiswa()
    {

        // Ambil parameter dari request DataTables
        $start = $this->request->getVar('start');
        $length = $this->request->getVar('length');
        $draw = $this->request->getVar('draw');
        $searchValue = $this->request->getVar('search')['value'] ?? '';
        $angkatan = $this->request->getGet('angkatan'); // Ambil parameter angkatan dari request
        $order = $this->request->getVar('order')[0];

        // Query builder
        $mSiswa = new ModelSiswa();
        $builder = $mSiswa->builder();
        $builder->select('siswa.*, 
        angkatan_masuk.angkatan AS masuk, 
        angkatan_keluar.angkatan AS keluar');
        $builder->join('angkatan angkatan_masuk', 'angkatan_masuk.id = siswa.masuk', 'left');
        $builder->join('angkatan angkatan_keluar', 'angkatan_keluar.id = siswa.keluar', 'left');
        $builder->where('siswa.id_sekolah', session()->get('user')['sekolah']['id']);

        // Filter berdasarkan angkatan jika ada
        if (!empty($angkatan)) {
            $builder->where('siswa.masuk', $angkatan);
        }

        // Filter pencarian jika ada
        if (!empty($searchValue)) {
            $builder->like('siswa.nama', $searchValue); // Misalnya pencarian berdasarkan nama
        }

        // Hitung total record sebelum limit
        $totalRecords = $builder->countAllResults(false);

        // order
        $builder->orderBy('nama', $order['dir']);

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

    public function getSiswaByAngkatan($angkatan)
    {
        $model = new ModelSiswa();

        // Ambil parameter dari request DataTables
        $start = $this->request->getVar('start');
        $length = $this->request->getVar('length');
        $draw = $this->request->getVar('draw');
        $searchValue = $this->request->getVar('search')['value'] ?? '';
        $order = $this->request->getVar('order')[0];

        $mAngkatan = new ModelAngkatan();
        $angkatanMasuk = $mAngkatan->where('angkatan', $angkatan)->first();
        if ($angkatanMasuk) {
            $angkatan = $angkatanMasuk['id'];
        } else {
            $angkatan = null;
        }

        // Query builder
        $mSiswa = new ModelSiswa();
        $builder = $mSiswa->builder();
        $builder->select('siswa.*, 
        angkatan_masuk.angkatan AS masuk, 
        angkatan_keluar.angkatan AS keluar');
        $builder->join('angkatan angkatan_masuk', 'angkatan_masuk.id = siswa.masuk', 'left');
        $builder->join('angkatan angkatan_keluar', 'angkatan_keluar.id = siswa.keluar', 'left');
        $builder->where('siswa.id_sekolah', session()->get('user')['sekolah']['id']);
        $builder->where('siswa.masuk', $angkatan);


        // Filter pencarian jika ada
        if (!empty($searchValue)) {
            $builder->like('nama', $searchValue); // Misalnya pencarian berdasarkan nama
        }

        // Hitung total record sebelum limit
        $totalRecords = $builder->countAllResults(false);

        // order
        $builder->orderBy('nama', $order['dir']);

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


    public function addSiswa()
    {
        $siswa = new ModelSiswa();
        $kelas = new ModelKelas();

        $data = [
            'id_sekolah' => $this->request->getPost('id_sekolah'),
            'id_status' => $this->request->getPost('status_masuk'),
            'nis' => $this->request->getPost('nis'),
            'nama' => $this->request->getPost('nama'),
            'jk' => $this->request->getPost('jk'),
            'tempat_lahir' => $this->request->getPost('tempat_lahir'),
            'tgl_lahir' => $this->request->getPost('tgl_lahir'),
            'orang_tua' => $this->request->getPost('ortu'),
        ];

        $idMasuk = $this->request->getPost('masuk');
        $angkatanMasuk = $this->mAngkatan->where('angkatan', $idMasuk)->first();
        if ($angkatanMasuk) {
            $data['masuk'] = $angkatanMasuk['id'];
        } else {
            $data['masuk'] = null;
        }

        $buktiMasuk = $this->request->getFile('bukti_masuk');
        if ($buktiMasuk->isValid() && !$buktiMasuk->hasMoved()) {
            $newName = $buktiMasuk->getRandomName();
            $buktiMasuk->move(ROOTPATH, $newName);
            $data['bukti_masuk'] = $newName;
        }

        $simpanSiswa = $siswa->insert($data);

        if ($simpanSiswa) {
            $id_siswa = $siswa->insertID();
            $dataKelas = [
                'id_sekolah' => $this->request->getPost('id_sekolah'),
                'id_siswa' => $id_siswa,
                'kelas' => 1,
                'ta' => $angkatanMasuk['id'],
                'created_at' => date('Y-m-d H:i:s')
            ];
            $kelas->insert($dataKelas);

            //set flashdata
            session()->setFlashdata('success', 'Data siswa berhasil ditambahkan');
            return redirect()->back();
        }
    }

    public function bulkSiswa()
    {
        $angkatan = $this->mAngkatan->where('id_sekolah', session()->get('user')['sekolah']['id'])->findAll();
        $data = [
            'title' => 'Tambah Angkatan Siswa',
            'content' => 'sekolah/v_bulk_siswa',
            'apath' => 'bulkSiswa',
            'user' => session()->get('user'),
            'angkatan' => $angkatan,
        ];
        return view('layouts/v_wrapper', $data);
    }

    public function saveBulkSiswa()
    {
        $siswa = new ModelSiswa();
        $kelas = new ModelKelas();
        $file = $this->request->getFile('csv');
        // $csvData = array_map('str_getcsv', file($file));

        $delimiter = $this->request->getPost('delimiter');
        if ($delimiter == ',') {
            $csvData = array_map(function ($v) {
                return str_getcsv($v, ',');
            }, file($file));
        } else {
            $csvData = array_map(function ($v) {
                return str_getcsv($v, ';');
            }, file($file));
        }

        $header = array_shift($csvData);

        // exisiting data
        $existingData = $siswa->where('id_sekolah', session()->get('user')['sekolah']['id'])->findAll();
        $existingNis = array_column($existingData, 'nis');


        foreach ($csvData as $row) {
            if (!in_array($row[0], $existingNis)) {
                $data = [
                    'id_sekolah' => session()->get('user')['sekolah']['id'],
                    'nis' => $row[0],
                    'nama' => $row[1],
                    'jk' => $row[2],
                    'tempat_lahir' => $row[3],
                    'tgl_lahir' => $row[4],
                    'orang_tua' => $row[5],
                    'masuk' => $row[6],
                    'keluar' => $row[7],
                    'created_at' => date('Y-m-d H:i:s')
                ];

                $insiswa = $siswa->insert($data);

                if ($insiswa) {
                    $id_siswa = $siswa->insertID();
                    $dataKelas = [
                        'id_sekolah' => session()->get('user')['sekolah']['id'],
                        'id_siswa' => $id_siswa,
                        'kelas' => 1,
                        'ta' => $row[6],
                        'created_at' => date('Y-m-d H:i:s')
                    ];
                    $kelas->insert($dataKelas);
                }
            }
        }

        session()->setFlashdata('success', 'Data siswa berhasil ditambahkan');
        return redirect()->to('/sekolah/siswa')->withInput();
    }

    public function editSiswa()
    {
        $siswa = new ModelSiswa();

        $id = $this->request->getPost('id');
        $data = [
            // 'id_sekolah' => $this->request->getPost('id_sekolah'),
            'id_status' => $this->request->getPost('status'),
            'nis' => $this->request->getPost('nis'),
            'nama' => $this->request->getPost('nama'),
            'jk' => $this->request->getPost('jk'),
            'tempat_lahir' => $this->request->getPost('tempat_lahir'),
            'tgl_lahir' => $this->request->getPost('tgl_lahir'),
            'orang_tua' => $this->request->getPost('ortu'),
            // 'masuk' => $this->request->getPost('masuk'),
            // 'keluar' => $this->request->getPost('keluar'),
            'updated_at' => date('Y-m-d H:i:s')
        ];

        $siswa->update($id, $data);
        //set flashdata
        session()->setFlashdata('success', 'Data siswa berhasil diubah');
        return redirect()->to('/sekolah/siswa');
    }

    public function profil()
    {
        $sekolah = new ModelSekolah();
        $data = [
            'title' => 'Profil Sekolah',
            'content' => 'sekolah/v_profil',
            'apath' => 'profil',
            'user' => session()->get('user'),
            'sekolah' => $sekolah->where('id', session()->get('user')['sekolah']['id'])->first()
        ];
        return view('layouts/v_wrapper', $data);
    }

    public function getCsv()
    {
        $file = ROOTPATH . 'public/uploads/file/template_siswa.csv';
        return $this->response->download($file, null);
    }
}
