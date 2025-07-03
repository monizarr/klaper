<!-- view cetak data siswa -->
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cetak Data Siswa</title>
    <link rel="stylesheet" href="<?= base_url('assets/css/bootstrap.min.css') ?>">
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
        }

        .container {
            max-width: 800px;
            margin: auto;
        }

        .header {
            text-align: center;
            margin-bottom: 20px;
        }

        .header img {
            width: 100px;
            height: auto;
        }

        .header h1 {
            margin: 10px 0;
        }

        .header p {
            margin: 0;
        }

        .table {
            width: 100%;
            border-collapse: collapse;
        }

        .table th,
        .table td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }

        .table th {
            background-color: #f2f2f2;
        }

        .footer {
            text-align: center;
            margin-top: 20px;
        }

        .footer p {
            margin: 0;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="header">
            <h2 style="margin-bottom: 0.5em;">Data Siswa <br /> <?= $sekolah['nama'] ?></h2>
            <p style="margin-top: 0;">Angkatan: <?= $angkatan['nama_angkatan'] ?></p>
        </div>

        <hr style="opacity: 0.5; margin-bottom: 2em;" />

        <h3>Data Pribadi Siswa</h3>
        <div class="student-data">
            <?php if (empty($siswa)): ?>
                <p class="text-center">Tidak ada data siswa.</p>
            <?php else: ?>
                <table class="table mb-4">
                    <tbody>
                        <tr>
                            <th width="30%">NIS</th>
                            <td><?= is_array($siswa) ? $siswa['nis'] : $siswa ?></td>
                        </tr>
                        <tr>
                            <th>Nama Siswa</th>
                            <td><?= $siswa['nama'] ?></td>
                        </tr>
                        <tr>
                            <th>Jenis Kelamin</th>
                            <td><?= $siswa['jk'] ?></td>
                        </tr>
                        <tr>
                            <th>Angkatan</th>
                            <td><?= $angkatan['nama_angkatan'] ?></td>
                        </tr>
                        <tr>
                            <th>Orang Tua</th>
                            <td><?= isset($siswa['orang_tua']) ? $siswa['orang_tua'] : '-' ?></td>
                        </tr>
                    </tbody>
                </table>
            <?php endif; ?>
        </div>
        <hr class="mt-4" style="opacity: 0.3; margin-top: 2em;" />

        <?php if (empty($riwayat)): ?>
            <p class="text-center">Tidak ada data siswa.</p>
        <?php else: ?>
            <h3>Data Akademis</h3>
            <div class="student-data">
                <table class="table">
                    <thead>
                        <tr>
                            <!-- <th>No</th> -->
                            <th>Kelas</th>
                            <th>Tahun Ajaran</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($riwayat as $index => $data): ?>
                            <tr>
                                <!-- <td><?= $index + 1 ?></td> -->
                                <td><?= $data['kelas'] ?></td>
                                <td><?= $data['angkatan'] ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php endif; ?>

        <hr class="mt-4" style="opacity: 0.3; margin-top: 2em;" />
        <h3>Data Prestasi</h3>
        <?php if (empty($prestasi)): ?>
            <p class="text-center">Tidak ada data prestasi.</p>
        <?php else: ?>
            <div class="student-data">
                <table class="table">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Kegiatan</th>
                            <th>Juara</th>
                            <th>Tingkat</th>
                            <th>Penyelenggara</th>
                            <th>Deskripsi</th>
                            <th>Tanggal Prestasi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($prestasi as $index => $data): ?>
                            <tr>
                                <td><?= $index + 1 ?></td>
                                <td><?= $data['kegiatan'] ?></td>
                                <td><?= $data['juara'] ?></td>
                                <td><?= $data['tingkat'] ?></td>
                                <td><?= $data['penyelenggara'] ?></td>
                                <td><?= $data['deskripsi'] ?></td>
                                <td><?= $data['tanggal_prestasi'] ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php endif; ?>

        <div class="footer mt-5" style="margin-top: 10em;">
            <p>&copy; <?= date('Y') ?> <?= $sekolah['nama'] ?>. <br /> Aplikasi Klaper Siswa Kabupaten Pekalongan.</p>
            <p>Dicetak pada: <?= date('d-m-Y H:i:s') ?></p>
        </div>
    </div>

    <!-- Optional JavaScript -->
    <!-- Bootstrap JS -->
    <script src="<?= base_url('assets/js/bootstrap.bundle.min.js') ?>"></script>
    <script>
        window.print();
    </script>
</body>

</html>
<?php
// End of file v_cetak.php
// Location: app/Views/sekolah/siswa/v_cetak.php
?><?php
// This file is used to display the print view of student data
// It includes the necessary HTML structure and styles for printing
// The data is passed from the controller to this view
// The view displays the school logo, student data in a table format, and includes a print script
// The print script is executed automatically when the page loads
// The view is designed to be printed, so it has minimal styling and a clean layout
// The data displayed includes student NISN, name, class, and   
