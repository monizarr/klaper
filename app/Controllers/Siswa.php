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
        $siswaModel = new ModelSiswa();
        $builder = $siswaModel->builder();
        $builder->select('angkatan.angkatan as tahun, siswa.jk, COUNT(siswa.id) as jumlah');
        $builder->join('angkatan', 'angkatan.id = siswa.masuk');
        $builder->where('siswa.id_sekolah', session()->get('user')['sekolah']['id']);
        $builder->groupBy(['angkatan.angkatan', 'siswa.jk']);
        $builder->orderBy('angkatan.angkatan', 'ASC');
        $result = $builder->get()->getResultArray();

        $angkatan = [];
        foreach ($result as $row) {
            $angkatan[$row['tahun']][$row['jk']] = $row['jumlah'];
        }

        //return json
        return $this->response->setJSON($angkatan);
    }

    public function siswaAngkatanSekolah()
    {
        $siswaModel = new ModelSiswa();
        $builder = $siswaModel->builder();
        $builder->select('angkatan.angkatan as tahun, siswa.jk, COUNT(siswa.id) as jumlah, sekolah.nama as nama_sekolah');
        $builder->join('angkatan', 'angkatan.id = siswa.masuk');
        $builder->join('sekolah', 'sekolah.id = siswa.id_sekolah');
        $builder->groupBy(['angkatan.angkatan', 'siswa.jk', 'sekolah.nama']);
        $builder->orderBy('angkatan.angkatan', 'ASC');
        $result = $builder->get()->getResultArray();

        $output = [];

        foreach ($result as $row) {
            $sekolah = $row['nama_sekolah'];
            $tahun = $row['tahun'];
            $jk = $row['jk'];
            $jumlah = (string)$row['jumlah']; // agar sesuai contoh JSON

            if (!isset($output[$sekolah])) {
                $output[$sekolah] = [];
            }
            if (!isset($output[$sekolah][$tahun])) {
                $output[$sekolah][$tahun] = [];
            }

            $output[$sekolah][$tahun][$jk] = $jumlah;
        }

        return $this->response->setJSON($output);
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
        try {
            $id = $this->request->getPost('id');
            $file = $this->request->getFile('bukti_keluar');

            $namaFile = $file->getRandomName();
            $file->move(ROOTPATH . 'public/uploads/file',  $namaFile);

            $mSiswa = new ModelSiswa();
            $siswa = $mSiswa->find($id);

            // hanya jpg, png dan pdf
            $allowedTypes = ['image/jpg', 'image/jpeg', 'image/png', 'application/pdf'];
            if (!in_array($file->getClientMimeType(), $allowedTypes)) {
                return redirect()->back()->with('error', 'File harus berupa jpg, png atau pdf');
            }
            // max size 2mb
            if ($file->getSize() > 2 * 1024 * 1024) {
                return redirect()->back()->with('error', 'File terlalu besar, maksimal 2MB');
            }

            // delete old file
            if ($siswa['bukti_keluar'] != null) {
                $filePath = ROOTPATH . 'public/uploads/file/' . $siswa['bukti_keluar'];

                if (file_exists($filePath)) {
                    unlink($filePath);
                }
            }

            $mAngkatan = new ModelAngkatan();
            $angkatanAktif = $mAngkatan->where('status', 1)->first();
            if (!$angkatanAktif) {
                return redirect()->back()->with('error', 'Tidak ada angkatan aktif');
            }
            $data = [
                'keluar' => $angkatanAktif['id'],
                'bukti_keluar' => $namaFile,
                'status_keluar' => 'lulus',
                'updated_at' => date('Y-m-d H:i:s'),
            ];

            $mSiswa->update($id, $data);

            return redirect()->back()->with('success', 'Data ijazah berhasil diupload');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal mengupload data ijazah :' . $e->getMessage());
        }
    }


    public function uploadSrtPindah()
    {
        try {

            $id = $this->request->getPost('id');
            $file = $this->request->getFile('bukti_keluar');
            $namaFile = $file->getRandomName();
            $file->move(ROOTPATH . 'public/uploads/file',  $namaFile);

            $mSiswa = new ModelSiswa();
            $siswa = $mSiswa->find($id);

            // hanya jpg, png dan pdf
            $allowedTypes = ['image/jpg', 'image/jpeg', 'image/png', 'application/pdf'];
            if (!in_array($file->getClientMimeType(), $allowedTypes)) {
                return redirect()->back()->with('error', 'File harus berupa jpg, png atau pdf');
            }
            // max size 2mb
            if ($file->getSize() > 2 * 1024 * 1024) {
                return redirect()->back()->with('error', 'File terlalu besar, maksimal 2MB');
            }

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
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal mengupload data surat pindah :' . $e->getMessage());
        }
    }

    public function uploadSrtKeluar()
    {
        try {

            $id = $this->request->getPost('id');
            $file = $this->request->getFile('bukti_keluar');
            $namaFile = $file->getRandomName();
            $file->move(ROOTPATH . 'public/uploads/file',  $namaFile);

            $mSiswa = new ModelSiswa();
            $siswa = $mSiswa->find($id);

            // hanya jpg, png dan pdf
            $allowedTypes = ['image/jpg', 'image/jpeg', 'image/png', 'application/pdf'];
            if (!in_array($file->getClientMimeType(), $allowedTypes)) {
                return redirect()->back()->with('error', 'File harus berupa jpg, png atau pdf');
            }
            // max size 2mb
            if ($file->getSize() > 2 * 1024 * 1024) {
                return redirect()->back()->with('error', 'File terlalu besar, maksimal 2MB');
            }

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
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal mengupload data surat putus sekolah :' . $e->getMessage());
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
