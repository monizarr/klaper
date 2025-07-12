<?php
$idSekolah =  explode('/', current_url());
$idSekolah = $idSekolah[count($idSekolah) - 3];
?>
<!-- Page header -->
<div class="page-header d-print-none">
    <div class="container-xl">
        <div class="row g-2 align-items-center">
            <div class="d-flex align-items-end col-1 gap-3">
                <div class="col">
                    <a href="javascript:window.history.go(-1);" class="btn btn-primary bg-light text-primary fs-3 p-1" style="border: 1px solid #066fd1; border-radius: 4px; box-sizing: border-box;">
                        <svg xmlns="http://www.w3.org/2000/svg" class="m-0 p-0" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-chevron-left">
                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                            <path d="M15 6l-6 6l6 6" />
                        </svg>
                    </a>
                </div>
                <div class="col-auto">
                    <!-- Page pre-title -->
                    <div class="page-pretitle">
                        <?= $user["username"] == 'admin' ? 'Admin' : $user["sekolah"]["nama"] ?>
                    </div>
                    <h2 class="page-title">
                        <?= $title ?>
                    </h2>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Page body -->
<div class="page-body">
    <div class="container-xl position-relative">
        <!-- Flash message -->
        <?php if (session()->getFlashdata('success')) : ?>
            <div class="alert alert-success alert-dismissible" role="alert">
                <div class="d-flex gap-2">
                    <div>
                        <svg xmlns="http://www.w3.org/2000/svg" class="icon alert-icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                            <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                            <path d="M5 12l5 5l10 -10"></path>
                        </svg>
                    </div>
                    <div>
                        <?= session()->getFlashdata('success') ?>
                    </div>
                </div>
                <a class="btn-close" data-bs-dismiss="alert" aria-label="close"></a>
            </div>
        <?php elseif (session()->getFlashdata('error')) : ?>
            <div class="alert alert-danger alert-dismissible" role="alert">
                <div class="d-flex gap-2">
                    <div>
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-alert-square-rounded">
                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                            <path d="M12 3c7.2 0 9 1.8 9 9s-1.8 9 -9 9s-9 -1.8 -9 -9s1.8 -9 9 -9z" />
                            <path d="M12 8v4" />
                            <path d="M12 16h.01" />
                        </svg>
                    </div>
                    <div>
                        <?= session()->getFlashdata('error') ?>
                    </div>
                </div>
                <a class="btn-close" data-bs-dismiss="alert" aria-label="close"></a>
            </div>
        <?php endif; ?>
        <div class="row row-deck row-cards">
            <div class="col-12">
                <div class="card">
                    <div class="card-header d-flex">
                        <div style="flex: 1;">
                            <h3 class="card-title">Data Siswa</h3>
                        </div>
                    </div>
                    <div class="card-body">
                        <table id="userTable" class="display">
                            <thead>
                                <tr>
                                    <th>Kelas</th>
                                    <th>NIS</th>
                                    <th>Nama</th>
                                    <th>TA</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                <!-- Data akan diisi oleh DataTables -->
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php foreach ($siswa as $s) : ?>
    <div class="modal fade" id="modal-edit-<?= $s['id'] ?>" tabindex="-1" aria-labelledby="modal-edit-label-<?= $s['id'] ?>">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modal-edit-label-<?= $s['id'] ?>">Edit Siswa</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <ul class="nav nav-tabs" id="tabs-<?= $s['id'] ?>" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link active" id="tabs-home-tab-<?= $s['id'] ?>" data-bs-toggle="tab" data-bs-target="#tabs-home-<?= $s['id'] ?>" type="button" role="tab" aria-controls="tabs-profile-<?= $s['id'] ?>" aria-selected="false">Profil</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="tabs-profile-tab-<?= $s['id'] ?>" data-bs-toggle="tab" data-bs-target="#tabs-profile-<?= $s['id'] ?>" type="button" role="tab" aria-controls="tabs-profile-<?= $s['id'] ?>" aria-selected="false">Riwayat Akademis</button>
                        </li>
                    </ul>
                    <div class="tab-content" id="tabs-content-<?= $s['id'] ?>">
                        <div class="tab-pane fade show active" id="tabs-home-<?= $s['id'] ?>" role="tabpanel" aria-labelledby="tabs-home-tab-<?= $s['id'] ?>">
                            <form action="<?= site_url('/sekolah/edit-siswa') ?>" method="post" class="modal-content">
                                <div class="modal-body p-0 mt-4">
                                    <input type="text" hidden name="id" value="<?= $s['id'] ?>">
                                    <div class="mb-3">
                                        <label class="form-label">NIS</label>
                                        <input type="number" class="form-control" name="nis" placeholder="Nomor Induk Siswa" value="<?= $s['nis'] ?>">
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Nama</label>
                                        <input type="text" class="form-control" name="nama" placeholder="Masukan nama lengkap" value="<?= $s['nama'] ?>">
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Jenis Kelamin</label>
                                        <select class="form-select" name="jk">
                                            <option value="L" <?= $s['jk'] == 'L' ? 'selected' : '' ?>>L</option>
                                            <option value="P" <?= $s['jk'] == 'P' ? 'selected' : '' ?>>P</option>
                                        </select>
                                    </div>
                                    <div class="row mb-3">
                                        <div class="col-lg-6">
                                            <label class="form-label">Tempat Lahir</label>
                                            <input type="text" class="form-control" name="tempat_lahir" placeholder="Tempat Lahir" value="<?= $s['tempat_lahir'] ?>">
                                        </div>
                                        <div class="col-lg-6">
                                            <label class="form-label">Tanggal Lahir</label>
                                            <input type="date" class="form-control" name="tgl_lahir" value="<?= $s['tgl_lahir'] ?>">
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="mb-3">
                                            <label class="form-label">Status Masuk</label>
                                            <select class="form-select" name="status_masuk">
                                                <option value="ppdb" <?= $s['status_masuk'] == 'ppdb' ? 'selected' : '' ?>>PPDB</option>
                                                <option value="pindahan" <?= $s['status_masuk'] == 'pindahan' ? 'selected' : '' ?>>Pindahan</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Orang Tua</label>
                                        <input type="text" class="form-control" name="ortu" placeholder="Nama Ayah / Ibu" value="<?= $s['orang_tua'] ?>">
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-6">
                                            <div class="mb-3">
                                                <label class="form-label">Tahun Masuk</label>
                                                <input type="number" step="1" name="masuk" class="form-control" value="<?= $s['masuk'] ?>">
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="mb-3">
                                                <label class="form-label">Keluar</label>
                                                <input type="number" step="1" <?= $s['keluar'] == null ? 'disabled' : '' ?> name="keluar" class="form-control" value="<?= $s['keluar'] ?>">
                                            </div>
                                        </div>
                                    </div>
                                    <?php if ($s['keluar'] != null) : ?>
                                        <div class="col-lg-12">
                                            <div class="mb-3">
                                                <label class="form-label"> Status Keluar</label>
                                                <select class="form-select" name="status_keluar">
                                                    <option value="lulus" <?= $s['status_keluar'] == 'lulus' ? 'selected' : '' ?>>Lulus</option>
                                                    <option value="pindah" <?= $s['status_keluar'] == 'pindah' ? 'selected' : '' ?>>Pindah</option>
                                                    <option value="do" <?= $s['status_keluar'] == 'putus' ? 'selected' : '' ?>>Putus Sekolah</option>
                                                </select>
                                            </div>
                                        </div>
                                    <?php endif; ?>
                                </div>
                                <?php if ($s['bukti_masuk'] != null) : ?>
                                    <div class="modal-body">
                                        <div class="row">
                                            <!-- preview image -->
                                            <div class="col-lg-12">
                                                <div class="mb-3">
                                                    <label class="form-label w-100">Surat Penerimaan Siswa</label>
                                                    <!-- image/pdf -->
                                                    <?php if (pathinfo($s['bukti_masuk'], PATHINFO_EXTENSION) == 'pdf') : ?>
                                                        <embed src="<?= base_url(UPLOAD_PATH . '/' . $s['bukti_masuk']) ?>" type="application/pdf" width="100%" height="600px" />
                                                    <?php else : ?>
                                                        <img src="<?= base_url(UPLOAD_PATH . '/' . $s['bukti_masuk']) ?>" class="img-fluid" alt="bukti" />
                                                    <?php endif; ?>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                <?php endif; ?>
                                <?php if ($s['keluar'] != null) : ?>
                                    <div class="modal-body">
                                        <div class="row">
                                            <!-- preview image -->
                                            <div class="col-lg-12">
                                                <div class="mb-3">
                                                    <label class="form-label w-100">Surat Alumni</label>
                                                    <!-- image/pdf -->
                                                    <?php if (pathinfo($s['bukti_keluar'], PATHINFO_EXTENSION) == 'pdf') : ?>
                                                        <embed src="<?= base_url(UPLOAD_PATH . '/' . $s['bukti_keluar']) ?>" type="application/pdf" width="100%" height="600px" />
                                                    <?php else : ?>
                                                        <img src="<?= base_url(UPLOAD_PATH . '/' . $s['bukti_keluar']) ?>" class="img-fluid" alt="bukti" />
                                                    <?php endif; ?>

                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                <?php endif; ?>
                            </form>
                        </div>
                        <div class="tab-pane fade" id="tabs-profile-<?= $s['id'] ?>" role="tabpanel" aria-labelledby="tabs-profile-tab-<?= $s['id'] ?>">
                            <div class="mt-4" id="academic-history-<?= $s['id'] ?>">Memuat data...</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php endforeach; ?>

<!-- Modal Confirm Delete -->
<div class="modal fade" id="modal-confirm-delete" tabindex="-1" aria-labelledby="modal-confirm-delete-label">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <form id="deleteForm" method="post">
                <div class="modal-header">
                    <h5 class="modal-title" id="modal-confirm-delete-label">Hapus Siswa</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>Anda akan menghapus data siswa <strong id="nisText"></strong></p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-link link-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-danger">Hapus</button>
                </div>
            </form>
        </div>
    </div>
</div>



<script>
    document.querySelectorAll('.modal').forEach(modal => {
        modal.addEventListener('show.bs.modal', function(event) {
            const siswaId = this.id.split('-')[2]; // Ambil ID siswa dari ID modal (e.g., 'modal-edit-2')
            console.log("Siswa ID : ", siswaId);
            fetch(`http://localhost:8080/siswa/get-kelas-siswa/${siswaId}`)
                .then(response => response.json())
                .then(result => {
                    const data = result.data;
                    const targetDiv = document.querySelector(`#tabs-profile-${siswaId}`);

                    console.log(data);

                    const kelasPlus = parseInt(data[data.length - 1]['kelas']) + 1;
                    const kelasTerakhir = parseInt(data[data.length - 1]['kelas']);

                    const isLulus = data[data.length - 1]['bukti'] != null && data[data.length - 1]['status_keluar'] == 'lulus';
                    const isPindah = data[data.length - 1]['bukti'] != null && data[data.length - 1]['status_keluar'] == 'pindah';
                    const isDo = data[data.length - 1]['bukti'] != null && data[data.length - 1]['status_keluar'] == 'putus';

                    if (Array.isArray(data) && data.length > 0) {
                        targetDiv.innerHTML = `
                        <div class="mt-4 row">
                            <h4>Riwayat Kelas</h4>
                            <table class="table table-bordered table-striped mt-2" id="table-riwayat-${siswaId}">
                                <thead>
                                    <tr>
                                        <th>Kelas</th>
                                        <th>Tahun Ajaran</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    ${data.map((item, index) => `
                                    <tr>
                                        <td>
                                            <input type="text" class="form-control" name="kelas-${item.id}" id="kelas-${item.id}" value="${item.kelas}" placeholder="Kelas">
                                        </td>
                                        <td>
                                            <input type="text" class="form-control" name="ta-${item.id}" id="ta-${item.id}" value="${item.ta}" placeholder="Tahun Ajaran">
                                        </td>
                                    </tr>
                                    `).join('')}
                                </tbody>
                            </table>
                        </div>
                        `;
                    } else {
                        targetDiv.innerHTML = '<p class="mt-4">Data tidak ditemukan.</p>';
                    }

                })
                .catch(error => {
                    const targetDiv = document.querySelector(`#tabs-profile-${siswaId}`);
                    targetDiv.innerHTML = `<p>Terjadi kesalahan: ${error.message}</p>`;
                });
        });
    });

    function updateRow(id) {
        const kelas = document.getElementById(`kelas-${id}`).value;
        const ta = document.getElementById(`ta-${id}`).value;

        console.log(kelas, ta);

        // Kirim data ke server menggunakan fetch API
        fetch(`<?= site_url('/kelas/update/') ?>${id}`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify({
                    kelas,
                    ta,
                }),
            })
            .then((response) => {
                console.log(response);
                if (response.ok) {
                    alert('Data berhasil diperbarui');
                } else {
                    alert('Terjadi kesalahan saat memperbarui data');
                }
            })
            .catch((error) => {
                console.error('Error:', error);
                alert('Terjadi kesalahan saat memperbarui data');
            });
    }

    function deleteRow(id) {
        // Kirim data ke server menggunakan fetch API
        fetch(`<?= site_url('/kelas/delete/') ?>${id}`, {
                method: 'POST',
            })
            .then((response) => {
                console.log(response);
                if (response.ok) {
                    alert('Data berhasil dihapus');
                    // Hapus baris dari tabel
                    document.getElementById(`kelas-${id}`).closest('tr').remove();
                } else {
                    alert('Terjadi kesalahan saat menghapus data');
                }
            })
            .catch((error) => {
                console.error('Error:', error);
                alert('Terjadi kesalahan saat menghapus data');
            });
    }

    // ketika #status_masuk == 'pindahan' maka tampilkan form surat pindah
    $(document).ready(function() {
        $('#status_masuk').change(function() {
            if ($(this).val() == 'pindahan') {
                $('#surat_pindah').show();
            } else {
                $('#surat_pindah').hide();
            }
        });
    });

    $(document).on('click', '[data-bs-target="#modal-confirm-delete"]', function() {
        const nis = $(this).data('nis');
        const id = $(this).data('id');
        const nama = $(this).data('nama');

        $('#nisText').text(nama);
        $('#deleteForm').attr('action', `<?= site_url('/siswa/del-siswa/') ?>${id}`);
    });

    $(document).on('click', '[data-bs-target^="#modal-edit-"]', function() {
        const id = $(this).data('id');
        const nis = $(this).data('nis');
        const nama = $(this).data('nama');
        const jk = $(this).data('jk');
        const ortu = $(this).data('ortu');

        // Update modal fields with data
        $(`#modal-edit-${id} #editNis`).val(nis);
        $(`#modal-edit-${id} #editNama`).val(nama);
        $(`#modal-edit-${id} #editJk`).val(jk);
        $(`#modal-edit-${id} #editOrtu`).val(ortu);
        $(`#modal-edit-${id} #editForm`).attr('action', `<?= site_url('/siswa/edit-siswa/') ?>${id}`);
    });



    $(document).ready(function() {
        let path = window.location.pathname.split('/');
        let sekolah = path[path.length - 5];
        let angkatan = path[path.length - 3];
        let kelas = path[path.length - 1];

        let table = $('#userTable').DataTable({
            "processing": true,
            "serverSide": true,
            "ajax": {
                "url": "<?= site_url('/kelas/admin-get-perkelas-ajax/') ?>" + sekolah + "/" + angkatan + "/" + kelas,
                "type": "GET",
                "data": function(d) {
                    d.angkatan = $('#dropdown-angkatan').attr('data-selected'); // Tambahkan parameter angkatan
                }
            },
            "columns": [{
                    "data": "kelas"
                },
                {
                    "data": "nis"
                },
                {
                    "data": "nama"
                },
                {
                    "data": "ta"
                },
                {
                    "data": "siswa_id",
                    "render": function(data, type, row) {
                        return `
                    <a href="<?= base_url('/siswa/cetak/') ?>${sekolah}/${data}" class="btn btn-sm btn-neutral" target="_blank">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-printer"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M5 8h14a2 2 0 0 1 2 2v6a2 2 0 0 1 -2 2h-14a2 2 0 0 1 -2 -2v-6a2 2 0 0 1 2 -2z" /><path d="M9 18v-4a1 1 0 0 1 1 -1h4a1 1 0 0 1 1 1v4" /><path d="M7.5 8l-3.5 -3.5l3.5 -3.5m9.5 -1.5l3.5 -3.5l3.5 -3.5m-16.5 .5l-3.5 -3.5l-3.5 -3.5m16.5 .5l3.5 -3.5l3.5 -3.5m-16 .5l-3.5 -3.5l-3.5 -3.5m16 .5l3.5 -3.5l3.5 -3.5m-16 .5l-3.5 -3.5l-3.5 -3.5m16 .5l3.5 -3.5l3.5 -3.5"/></svg>
                        Cetak
                    </a>
                    <a href="#" class="btn btn-sm btn-primary" 
                        data-bs-toggle="modal" 
                        data-bs-target="#modal-edit-${data}" 
                        data-id="${data}" 
                        data-nis="${row.nis}" 
                        data-nama="${row.nama}" 
                        data-jk="${row.jk}" 
                        data-ortu="${row.orang_tua}">
                        Detail
                    </a>`;
                    }
                },
            ],
            "order": [
                [0, 'asc']
            ]
        });

        // Event listener untuk dropdown
        $('.dropdown-menu a').on('click', function(e) {
            e.preventDefault();

            // Dapatkan nilai angkatan dari item yang diklik
            let selectedAngkatan = $(this).text();

            // Tampilkan angkatan yang dipilih di tombol dropdown
            $('#dropdown-angkatan').text(selectedAngkatan).attr('data-selected', selectedAngkatan);

            // Reload data DataTable dengan parameter baru
            table.ajax.reload();
        });

    });
</script>