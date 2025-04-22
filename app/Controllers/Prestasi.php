<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\Angkatan;
use App\Models\Prestasi as ModelsPrestasi;
use CodeIgniter\HTTP\ResponseInterface;

class Prestasi extends BaseController
{
    public function index()
    {
        //
    }

    public function add()
    {
        $data = [
            'kegiatan' => $this->request->getVar('kegiatan'),
            'tingkat' => $this->request->getVar('tingkat'),
            'tempat' => $this->request->getVar('tempat'),
            'penyelenggara' => $this->request->getVar('penyelenggara'),
            'juara' => $this->request->getVar('juara'),
            'deskripsi' => $this->request->getVar('deskripsi'),
            'tanggal_prestasi' => $this->request->getVar('tanggal_prestasi'),
            'id_siswa' => $this->request->getVar('id_siswa'),
            'id_sekolah' => session()->get('user')['sekolah']['id'],
        ];

        $file = $this->request->getFile('sertifikat');
        if ($file) {
            $fileName = $file->getRandomName();
            $file->move('uploads/file', $fileName);
            $data['sertifikat'] = $fileName;
        }

        // Insert data
        $mPrestasi = new ModelsPrestasi();
        if ($mPrestasi->insert($data)) {
            return redirect()->back()->with('success', 'Data prestasi berhasil ditambahkan');
        } else {
            return redirect()->back()->with('error', 'Data prestasi gagal ditambahkan');
        }
    }

    // get data prestasi for datatable
    public function getPrestasiAjax($angkatan)
    {

        // Ambil parameter dari request DataTables
        $start = $this->request->getVar('start');
        $length = $this->request->getVar('length');
        $draw = $this->request->getVar('draw');
        $searchValue = $this->request->getVar('search')['value'] ?? '';
        $order = $this->request->getVar('order')[0];

        // konversi $angkatan ke tipe date dengan bulan 01 dan tanggal 01
        $awalAngkatan = date('Y-m-d', strtotime($angkatan . '-01-01'));
        $akhirAngkatan = date('Y-m-d', strtotime($angkatan . '-12-31'));

        // Query builder
        $mPrestasi = new ModelsPrestasi();
        $builder = $mPrestasi->builder();
        $builder->select('prestasi.*, siswa.nama, siswa.nis, siswa.masuk');
        $builder->join('siswa', 'siswa.id = prestasi.id_siswa', 'left');
        $builder->where('prestasi.id_sekolah', session()->get('user')['sekolah']['id']);
        $builder->where('siswa.id_sekolah', session()->get('user')['sekolah']['id']);
        // range data sesuai prestasi.tanggal_prestasi
        $builder->where('prestasi.tanggal_prestasi >=', $awalAngkatan);
        $builder->where('prestasi.tanggal_prestasi <=', $akhirAngkatan);

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

    public function update()
    {
        $id = $this->request->getVar('id');
        $data = [
            'kegiatan' => $this->request->getVar('kegiatan'),
            'tingkat' => $this->request->getVar('tingkat'),
            'tempat' => $this->request->getVar('tempat'),
            'penyelenggara' => $this->request->getVar('penyelenggara'),
            'juara' => $this->request->getVar('juara'),
            'deskripsi' => $this->request->getVar('deskripsi'),
            'tanggal_prestasi' => $this->request->getVar('tanggal_prestasi'),
        ];

        $file = $this->request->getFile('sertifikat');
        if ($file) {
            $fileName = $file->getRandomName();
            $file->move('uploads/sertifikat', $fileName);
            $data['sertifikat'] = $fileName;
        }

        // Update data
        $mPrestasi = new ModelsPrestasi();
        if ($mPrestasi->update($id, $data)) {
            return redirect()->back()->with('success', 'Data prestasi berhasil diupdate');
        } else {
            return redirect()->back()->with('error', 'Data prestasi gagal diupdate');
        }
    }

    public function delete($id)
    {
        $mPrestasi = new ModelsPrestasi();
        if ($mPrestasi->delete($id)) {
            return redirect()->back()->with('success', 'Data prestasi berhasil dihapus');
        } else {
            return redirect()->back()->with('error', 'Data prestasi gagal dihapus');
        }
    }
}
