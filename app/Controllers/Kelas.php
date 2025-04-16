<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\Kelas as ModelKelas;

class Kelas extends BaseController
{

    protected $mKelas, $mSiswa;
    public function __construct()
    {
        $this->mKelas = new ModelKelas();
        $this->mSiswa = new \App\Models\Siswa();
    }

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
            'created_at' => date('Y-m-d H:i:s')
        ];

        $siswaAktif = $this->mSiswa->where('id', $data['id_siswa'])->first();
        if ($siswaAktif && $siswaAktif['status_keluar'] != null) {
            session()->setFlashdata('error', 'Siswa tidak aktif');
            return redirect()->back();
        }

        $mAngkatan = new \App\Models\Angkatan();
        $angkatanAktif = $mAngkatan->where('id_sekolah', $data['id_sekolah'])->where('status', 1)->first();

        if (!$angkatanAktif) {
            session()->setFlashdata('error', 'Tidak ada angkatan aktif');
            return redirect()->back();
        }

        $data['ta'] = $angkatanAktif['id'];

        $kelasTerakhir = $this->mKelas->where('id_siswa', $data['id_siswa'])->orderBy('ta', 'DESC')->first();
        $taSebelumnya = $mAngkatan->where('id', $kelasTerakhir['ta'])->first()["angkatan"];
        //memastikan tahun aktif sekarang lebih dari tahun ajaran siswa
        $tahunAktif = $mAngkatan->where('id', $data['ta'])->first()['angkatan'];

        // dd($tahunAktif, $taSebelumnya, $tahunAktif <= $taSebelumnya);

        if ($tahunAktif <= $taSebelumnya) {
            session()->setFlashdata('error', 'Tahun ajaran aktif harus lebih dari tahun ajaran siswa sebelumnya');
            return redirect()->back();
        } else if ($tahunAktif != $taSebelumnya + 1) {
            session()->setFlashdata('error', 'Terjadi kesalahan pada tahun ajaran aktif');
            return redirect()->back();
        }

        // cek kelas terakhir siswa
        $kelasTerakhir = $this->mKelas->where('id_siswa', $data['id_siswa'])->orderBy('id', 'DESC')->first();
        // limit kelas hanya sampai 6
        if ($kelasTerakhir) {
            if ($kelasTerakhir['kelas'] >= 6) {
                session()->setFlashdata('error', 'Siswa sudah mencapai kelas 6');
                return redirect()->back();
            }
        }

        $this->mKelas->insert($data);

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

    // get kelas siswa for datatables
    public function getKelasSiswa()
    {
        $mKelas = new ModelKelas();

        // Ambil parameter dari request DataTables
        $start = $this->request->getVar('start');
        $length = $this->request->getVar('length');
        $draw = $this->request->getVar('draw');
        $searchValue = $this->request->getVar('search')['value'] ?? '';
        $order = $this->request->getVar('order')[0];

        // Query builder
        $builder = $mKelas->builder();

        // Subquery untuk mendapatkan kelas terbaru untuk setiap siswa
        $subQuery = $mKelas->builder()
            ->select('id_siswa, MAX(kelas) as max_kelas')
            ->where('id_sekolah', session()->get('user')['sekolah']['id'])
            ->groupBy('id_siswa')
            ->getCompiledSelect();

        // Join dengan subquery untuk mendapatkan data kelas terbaru
        $builder->select('kelas.id, kelas.kelas, angkatan.angkatan AS ta, siswa.nama, siswa.nis, siswa.id as siswa_id');
        $builder->join('siswa', 'siswa.id = kelas.id_siswa');
        $builder->join("($subQuery) as latest_kelas", 'latest_kelas.id_siswa = kelas.id_siswa AND latest_kelas.max_kelas = kelas.kelas');
        $builder->join('angkatan', 'angkatan.id = kelas.ta');

        $builder->where('kelas.id_sekolah', session()->get('user')['sekolah']['id']);

        if (!empty($searchValue)) {
            $builder->groupStart();
            $builder->like('siswa.nama', $searchValue);
            $builder->orLike('siswa.nis', $searchValue);
            $builder->orLike('kelas.kelas', $searchValue);
            $builder->orLike('kelas.ta', $searchValue);
            $builder->groupEnd();
        }

        $totalKelas = $mKelas->countAllResults(false);

        $builder->orderBy('kelas.kelas', $order['dir']);

        $data = $builder->limit($length, $start)->get()->getResultArray();

        $totalFiltered = count($data);

        $data = [
            'draw' => $draw,
            'recordsTotal' => $totalKelas,
            'recordsFiltered' => $totalFiltered,
            'data' => $data
        ];

        return $this->response->setJSON($data);
    }

    public function getKelasSiswaByTa($ta)
    {
        $mKelas = new ModelKelas();
        $mAngkatan = new \App\Models\Angkatan();

        // Ambil parameter dari request DataTables
        $start = $this->request->getVar('start');
        $length = $this->request->getVar('length');
        $draw = $this->request->getVar('draw');
        $searchValue = $this->request->getVar('search')['value'] ?? '';
        $order = $this->request->getVar('order')[0];

        $tahunMasuk = $mAngkatan->where('angkatan', $ta)->first()['id'];

        // Query builder
        $builder = $mKelas->builder();

        // Subquery untuk mendapatkan kelas terbaru untuk setiap siswa
        $subQuery = $mKelas->builder()
            ->select('id_siswa, MAX(kelas) as max_kelas')
            ->where('id_sekolah', session()->get('user')['sekolah']['id'])
            ->groupBy('id_siswa')
            ->getCompiledSelect();

        $subQueryMaxTa = $mKelas->builder()
            ->select('id_siswa, MAX(ta) as max_ta')
            ->where('id_sekolah', session()->get('user')['sekolah']['id'])
            ->groupBy('id_siswa')
            ->getCompiledSelect();


        // Join dengan subquery untuk mendapatkan data kelas terbaru
        $builder->select('kelas.id, kelas.kelas,  siswa.nama, siswa.nis, siswa.id as siswa_id, angkatan.angkatan as ta, siswa.masuk as tahun_masuk');
        $builder->join('siswa', 'siswa.id = kelas.id_siswa');
        $builder->join("($subQuery) as latest_kelas", 'latest_kelas.id_siswa = kelas.id_siswa AND latest_kelas.max_kelas = kelas.kelas');
        $builder->join("($subQueryMaxTa) as latest_ta", 'latest_ta.id_siswa = kelas.id_siswa AND latest_ta.max_ta = kelas.ta');
        $builder->join('angkatan', 'angkatan.id = kelas.ta');

        $builder->where('kelas.id_sekolah', session()->get('user')['sekolah']['id']);
        // $builder->where('angkatan.status', 1);
        $builder->where('siswa.masuk', $tahunMasuk);

        if (!empty($searchValue)) {
            $builder->groupStart();
            $builder->like('siswa.nama', $searchValue);
            $builder->orLike('siswa.nis', $searchValue);
            $builder->orLike('kelas.kelas', $searchValue);
            $builder->orLike('kelas.ta', $searchValue);
            $builder->groupEnd();
        }

        $totalKelas = $mKelas->countAllResults(false);

        $builder->orderBy('kelas.kelas', $order['dir']);

        $data = $builder->limit($length, $start)->get()->getResultArray();

        $totalFiltered = count($data);

        $data = [
            'draw' => $draw,
            'recordsTotal' => $totalKelas,
            'recordsFiltered' => $totalFiltered,
            'data' => $data
        ];

        return $this->response->setJSON($data);
    }

    public function getKelasSiswaByKelas($angkatan, $kelas)
    {
        $mKelas = new ModelKelas();

        // Ambil parameter dari request DataTables
        $start = $this->request->getVar('start');
        $length = $this->request->getVar('length');
        $draw = $this->request->getVar('draw');
        $searchValue = $this->request->getVar('search')['value'] ?? '';
        $order = $this->request->getVar('order')[0];

        $mAngkatan = new \App\Models\Angkatan();
        $tahunMasuk = $mAngkatan->where('angkatan', $angkatan)->first()['id'];

        // Query builder
        $builder = $mKelas->builder();

        // Subquery untuk mendapatkan kelas terbaru untuk setiap siswa
        $subQuery = $mKelas->builder()
            ->select('id_siswa, MAX(kelas) as max_kelas')
            ->where('id_sekolah', session()->get('user')['sekolah']['id'])
            ->groupBy('id_siswa')
            ->getCompiledSelect();

        $subQueryMaxTa = $mKelas->builder()
            ->select('id_siswa, MAX(ta) as max_ta')
            ->where('id_sekolah', session()->get('user')['sekolah']['id'])
            ->groupBy('id_siswa')
            ->getCompiledSelect();

        // Join dengan subquery untuk mendapatkan data kelas terbaru
        $builder->select('kelas.id, kelas.kelas,  siswa.nama, siswa.nis, siswa.id as siswa_id, angkatan.angkatan as ta');
        $builder->join('siswa', 'siswa.id = kelas.id_siswa');
        $builder->join("($subQuery) as latest_kelas", 'latest_kelas.id_siswa = kelas.id_siswa AND latest_kelas.max_kelas = kelas.kelas');
        $builder->join("($subQueryMaxTa) as latest_ta", 'latest_ta.id_siswa = kelas.id_siswa AND latest_ta.max_ta = kelas.ta');
        $builder->join('angkatan', 'angkatan.id = kelas.ta');

        $builder->where('kelas.id_sekolah', session()->get('user')['sekolah']['id']);
        $builder->where('kelas.kelas', $kelas);
        $builder->where('siswa.masuk', $tahunMasuk);

        if (!empty($searchValue)) {
            $builder->groupStart();
            $builder->like('siswa.nama', $searchValue);
            $builder->orLike('siswa.nis', $searchValue);
            $builder->orLike('kelas.kelas', $searchValue);
            $builder->orLike('kelas.ta', $searchValue);
            $builder->groupEnd();
        }

        $totalKelas = $mKelas->countAllResults(false);

        $builder->orderBy('kelas.kelas', $order['dir']);

        $data = $builder->limit($length, $start)->get()->getResultArray();
        $totalFiltered = count($data);
        $data = [
            'draw' => $draw,
            'recordsTotal' => $totalKelas,
            'recordsFiltered' => $totalFiltered,
            'data' => $data
        ];
        return $this->response->setJSON($data);
    }
}
