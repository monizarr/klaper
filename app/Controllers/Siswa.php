<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\Siswa as ModelSiswa;
use App\Models\Kelas as ModelKelas;
use App\Models\Angkatan as ModelAngkatan;


class Siswa extends BaseController
{
    public function index()
    {
        $id_sekolah = $this->request->getGet('id_sekolah');

        $siswaModel = new ModelSiswa();
        if (empty($id_sekolah)) {
            // join with sekolah
            $select = 'siswa.*, sekolah.nama as nama_sekolah';
            $siswa = $siswaModel->select($select)->join('sekolah', 'sekolah.id = siswa.id_sekolah')->findAll();
        } else {
            $siswa = $siswaModel->where('id_sekolah', $id_sekolah)->findAll();
        }

        //return json
        return $this->response->setJSON($siswa);
    }

    public function show($id)
    {
        // get data from model
        $model = new ModelSiswa();
        $siswa = $model->find($id);

        return $this->response->setJSON($siswa);
    }


    public function getKelasSiswa($id_siswa)
    {
        $mKelas = new ModelKelas();
        $kelas = $mKelas->select('kelas.id, kelas.kelas, siswa.nama as nama_siswa, angkatan.angkatan as ta');
        $kelas = $mKelas->join('siswa', 'siswa.id = kelas.id_siswa')
            ->join('angkatan', 'angkatan.id = kelas.ta')
            ->where('kelas.id_siswa', $id_siswa)
            ->orderBy('kelas.kelas', 'ASC')
            ->findAll();
        $response = [
            'data' => $kelas
        ];

        return $this->response->setJSON($response);
    }

    public function getSiswaAngkatan($angkatan)
    {
        $mSiswa = new ModelSiswa();

        $user  = session()->get('user');
        $siswa = $mSiswa->where('id_sekolah', $user['sekolah']['id'])->where('masuk', $angkatan)->findAll();

        return $this->response->setJSON($siswa);
    }

    public function deleteSiswa($id)
    {
        $mSiswa = new ModelSiswa();
        $mSiswa->where('id', $id)->delete();

        //set flashdata
        session()->setFlashdata('success', 'Data siswa berhasil dihapus');
        return redirect()->to('/sekolah/siswa');
    }

    public function uploadIjazah()
    {
        $id = $this->request->getPost('id');
        $file = $this->request->getFile('bukti_keluar');

        $namaFile = $file->getRandomName();
        $file->move(ROOTPATH . 'public/uploads/file',  $namaFile);

        $mSiswa = new ModelSiswa();
        $siswa = $mSiswa->find($id);

        if ($siswa['bukti_keluar'] != null) {
            $filePath = ROOTPATH . 'public/uploads/file/' . $siswa['bukti_keluar'];

            if (file_exists($filePath)) {
                unlink($filePath);
            }
        }

        $mAngkatan = new ModelAngkatan();
        $angkatanAktif = $mAngkatan->where('status', 1)->first();

        $data = [
            'keluar' => $angkatanAktif['id'],
            'bukti_keluar' => $namaFile,
            'status_keluar' => 'lulus',
            'updated_at' => date('Y-m-d H:i:s'),
        ];

        $save = $mSiswa->update($id, $data);

        if ($save) {
            return redirect()->back()->with('success', 'Data ijazah berhasil diupload');
        } else {
            return redirect()->back()->with('error', 'Gagal mengupload data ijazah');
        }
    }


    public function uploadSrtPindah()
    {
        $id = $this->request->getPost('id');
        $file = $this->request->getFile('bukti_keluar');
        $namaFile = $file->getRandomName();
        $file->move(ROOTPATH . 'public/uploads/file',  $namaFile);

        $mSiswa = new ModelSiswa();
        $siswa = $mSiswa->find($id);
        if ($siswa['bukti_keluar'] != null) {
            $filePath = ROOTPATH . 'public/uploads/file/' . $siswa['bukti_keluar'];

            if (file_exists($filePath)) {
                unlink($filePath);
            }
        }

        $data = [
            'keluar' => date('Y'),
            'bukti_keluar' => $namaFile,
            'status_keluar' => 'pindah',
            'updated_at' => date('Y-m-d H:i:s'),
        ];

        $siswa = new ModelSiswa();
        $save = $siswa->update($id, $data);

        if ($save) {
            return redirect()->back()->with('success', 'Data surat pindah berhasil diupload');
        } else {
            return redirect()->back()->with('success', 'Data surat pindah berhasil diupload');
        }
    }

    public function uploadSrtKeluar()
    {
        $id = $this->request->getPost('id');
        $file = $this->request->getFile('bukti_keluar');
        $namaFile = $file->getRandomName();
        $file->move(ROOTPATH . 'public/uploads/file',  $namaFile);

        $mSiswa = new ModelSiswa();
        $siswa = $mSiswa->find($id);
        if ($siswa['bukti_keluar'] != null) {
            $filePath = ROOTPATH . 'public/uploads/file/' . $siswa['bukti_keluar'];

            if (file_exists($filePath)) {
                unlink($filePath);
            }
        }

        $data = [
            'keluar' => date('Y'),
            'bukti_keluar' => $namaFile,
            'status_keluar' => 'putus',
            'updated_at' => date('Y-m-d H:i:s'),
        ];

        $siswa = new ModelSiswa();
        $save = $siswa->update($id, $data);

        if ($save) {
            return redirect()->back()->with('success', 'Data surat putus sekolah berhasil diupload');
        } else {
            return redirect()->back()->with('success', 'Data surat putus sekolah berhasil diupload');
        }
    }

    public function search()
    {
        $query = $this->request->getGet('query');
        $model = new ModelSiswa();

        // Query database sesuai input user
        $results = $model
            ->like('nama', $query)
            ->where('id_sekolah', session()->get('user')['sekolah']['id'])
            ->findAll();

        // Mengembalikan hasil dalam format JSON
        return $this->response->setJSON($results);
    }
}
