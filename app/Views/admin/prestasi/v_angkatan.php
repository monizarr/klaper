<!-- Page header -->
<div class="page-header d-print-none">
    <div class="container-xl">
        <div class="row g-2 align-items-center">
            <div class="col">
                <!-- Page pre-title -->
                <div class="page-pretitle">
                    <?= $user["username"] == 'admin' ? 'Admin' : $user["sekolah"]["nama"] ?>
                </div>
                <h2 class="page-title">
                    Manajemen Siswa
                </h2>
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
                <div class="d-flex">
                    <div>
                        <!-- Download SVG icon from http://tabler-icons.io/i/check -->
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
            <div class="alert alert-success alert-dismissible" role="alert">
                <div class="d-flex">
                    <div>
                        <!-- Download SVG icon from http://tabler-icons.io/i/check -->
                        <svg xmlns="http://www.w3.org/2000/svg" class="icon alert-icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                            <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                            <path d="M5 12l5 5l10 -10"></path>
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
                                    <th>NIS</th>
                                    <th>Nama</th>
                                    <th>Kegiatan</th>
                                    <th>Tingkat</th>
                                    <th>Tempat</th>
                                    <th>Penyelenggara</th>
                                    <th>Juara</th>
                                    <th>Sertifikat</th>
                                    <th>Aksi</th>
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

<!-- Modal Edit -->
<?php foreach ($prestasi as $s) : ?>
    <div class="modal fade" id="modal-edit-<?= $s['id'] ?>" tabindex="-1" aria-labelledby="modal-edit-label-<?= $s['id'] ?>" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modal-edit-label-<?= $s['id'] ?>">Edit Siswa</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="<?= site_url('/prestasi/update') ?>" method="post" class="modal-content">
                        <div class="">
                            <input type="text" hidden name="id" value="<?= $s['id'] ?>">
                            <div class="mb-3">
                                <label class="form-label">Siswa</label>
                                <input type="text" class="form-control" name="nama" placeholder="Nomor Induk Siswa" value="<?= $s['nama_siswa'] ?>">
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Kegiatan</label>
                                <input type="text" class="form-control" name="kegiatan" placeholder="Masukan nama Kegiatan" value="<?= $s['kegiatan'] ?>">
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Tingkat</label>
                                <select class="form-select" name="tingkat">
                                    <option value="Internasional" <?= $s['tingkat'] == 'Internasional' ? 'selected' : '' ?>>Internasional</option>
                                    <option value="Nasional" <?= $s['tingkat'] == 'Nasional' ? 'selected' : '' ?>>Nasional</option>
                                    <option value="Provinsi" <?= $s['tingkat'] == 'Provinsi' ? 'selected' : '' ?>>Provinsi</option>
                                    <option value="Kabupaten/Kota" <?= $s['tingkat'] == 'Kabupaten/Kota' ? 'selected' : '' ?>>Kabupaten / Kota</option>
                                    <option value="Kecamatan" <?= $s['tingkat'] == 'Kecamatan' ? 'selected' : '' ?>>Kecamatan</option>
                                </select>
                            </div>
                            <div class="row mb-3">
                                <div class="col-lg-12">
                                    <label class="form-label">Tempat</label>
                                    <input type="text" class="form-control" name="tempat" placeholder="Tempat Pelaksanaan" value="<?= $s['tempat'] ?>">
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-lg-12">
                                    <label class="form-label">Penyelenggara</label>
                                    <input type="text" class="form-control" name="penyelenggara" placeholder="Penyelenggara" value="<?= $s['penyelenggara'] ?>">
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-lg-12">
                                    <label class="form-label">Juara</label>
                                    <select class="form-select" name="juara">
                                        <option value="juara1" <?= $s['juara'] == 'juara1' ? 'selected' : '' ?>>Juara 1</option>
                                        <option value="juara2" <?= $s['juara'] == 'juara2' ? 'selected' : '' ?>>Juara 2</option>
                                        <option value="juara3" <?= $s['juara'] == 'juara3' ? 'selected' : '' ?>>Juara 3</option>
                                        <option value="harapan1" <?= $s['juara'] == 'harapan1' ? 'selected' : '' ?>>Harapan 1</option>
                                        <option value="harapan2" <?= $s['juara'] == 'harapan2' ? 'selected' : '' ?>>Harapan 2</option>
                                        <option value="harapan3" <?= $s['juara'] == 'harapan3' ? 'selected' : '' ?>>Harapan 3</option>
                                    </select>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-lg-12">
                                    <label class="form-label">Deskripsi</label>
                                    <input type="text" class="form-control" name="deskripsi" placeholder="Deskripsi" value="<?= $s['deskripsi'] ?>">
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-lg-12">
                                    <label class="form-label">Tanggal</label>
                                    <input type="date" class="form-control" name="tanggal_prestasi" placeholder="Tanggal" value="<?= $s['tanggal_prestasi'] ?>">
                                </div>
                            </div>
                        </div>
                        <?php if ($s['sertifikat'] != null) : ?>
                            <div class="modal-body">
                                <div class="row">
                                    <!-- preview image -->
                                    <div class="col-lg-12">
                                        <div class="mb-3">
                                            <label class="form-label w-100">Surat Penerimaan Siswa</label>
                                            <!-- image/pdf -->
                                            <?php if (pathinfo($s['sertifikat'], PATHINFO_EXTENSION) == 'pdf') : ?>
                                                <embed src="<?= base_url(UPLOAD_PATH . '/' . $s['sertifikat']) ?>" type="application/pdf" width="100%" height="600px" />
                                            <?php else : ?>
                                                <img src="<?= base_url(UPLOAD_PATH . '/' . $s['sertifikat']) ?>" class="img-fluid" alt="bukti" />
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php endif; ?>
                        <div class="modal-footer">
                            <a href="#" class="btn btn-link link-secondary" data-bs-dismiss="modal">
                                Cancel
                            </a>
                            <button type="submit" class="btn btn-primary ms-auto">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-edit">
                                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                    <path d="M7 7h-1a2 2 0 0 0 -2 2v9a2 2 0 0 0 2 2h9a2 2 0 0 0 2 -2v-1" />
                                    <path d="M20.385 6.585a2.1 2.1 0 0 0 -2.97 -2.97l-8.415 8.385v3h3l8.385 -8.415z" />
                                    <path d="M16 5l3 3" />
                                </svg>
                                Ubah
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
<?php endforeach; ?>

<!-- Modal Confirm Delete -->
<div class="modal fade" id="modal-confirm-delete" tabindex="-1" aria-labelledby="modal-confirm-delete-label" aria-hidden="true">
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
    $(document).on('click', '[data-bs-target="#modal-confirm-delete"]', function() {
        const nis = $(this).data('nis');
        const id = $(this).data('id');
        const nama = $(this).data('nama');

        $('#nisText').text(nama);
        $('#deleteForm').attr('action', `<?= site_url('/prestasi/delete/') ?>${id}`);
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
        $(`#modal-edit-${id} #editForm`).attr('action', `<?= site_url('/prestasi/delete/') ?>${id}`);
    });

    // ajax for modal riwayat akademis
    $(document).ready(function() {
        $('a[data-bs-toggle="tab"]').on('shown.bs.tab', function(e) {
            var target = $(e.target).attr("data-bs-target");
            var id = target.split('-')[2];
            $.ajax({
                url: "<?= site_url('/siswa/get-kelas/siswa') ?>",
                type: "GET",
                data: {
                    id: id
                },
                success: function(response) {
                    $('#tabs-profile-' + id).html(response);
                }
            });
        });
    });

    $(document).ready(function() {
        // get angkatan from last path
        const path = window.location.pathname;
        const segments = path.split('/');
        const sekolah = segments[segments.length - 3];
        const angkatan = segments[segments.length - 1];

        let table = $('#userTable').DataTable({
            "processing": true,
            "serverSide": true,
            "ajax": {
                "url": "<?= site_url('/prestasi/ajax/get-sekolah') ?>/" + sekolah + "/angkatan/" + angkatan,
                "dataType": "json",
                "type": "GET",
            },
            "columns": [{
                    "data": "nis"
                },
                {
                    "data": "nama"
                },
                {
                    "data": "kegiatan"
                },
                {
                    "data": "tingkat"
                },
                {
                    "data": "tempat"
                },
                {
                    "data": "penyelenggara"
                },
                {
                    "data": "juara",
                    "render": function(data) {
                        if (data == 'juara1') {
                            return 'Juara 1';
                        } else if (data == 'juara2') {
                            return 'Juara 2';
                        } else if (data == 'juara3') {
                            return 'Juara 3';
                        } else if (data == 'harapan1') {
                            return 'Harapan 1';
                        } else if (data == 'harapan2') {
                            return 'Harapan 2';
                        } else if (data == 'harapan3') {
                            return 'Harapan 3';
                        }
                        return data;
                    }
                },
                {
                    "data": "sertifikat",
                    "render": function(data) {
                        if (data == null) {
                            return "<div style='text-align:center;'>-</div>";
                        }
                        return `<a href="<?= base_url('uploads/file') ?>/${data}" target="_blank">
                    <div style="text-align:center;"> 
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-eye"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M10 12a2 2 0 1 0 4 0a2 2 0 0 0 -4 0" /><path d="M21 12c-2.4 4 -5.4 6 -9 6c-3.6 0 -6.6 -2 -9 -6c2.4 -4 5.4 -6 9 -6c3.6 0 6.6 2 9 6" /></svg>
                        <span class="ms-1">Lihat</span>
                    </div>
                </a>`;
                    }
                },
                {
                    "data": "id",
                    "render": function(data, type, row) {
                        return `
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


        const searchInput = document.getElementById('searchInput');
        const searchDropdown = document.getElementById('searchDropdown');

        searchInput.addEventListener('input', function() {
            const query = searchInput.value;
            if (query.length > 2) { // Mulai pencarian jika input lebih dari 2 karakter
                fetch(`<?= site_url('/siswa/search') ?>?query=${query}`)
                    .then(response => response.json())
                    .then(data => {
                        // Kosongkan dropdown
                        searchDropdown.innerHTML = '';

                        // Isi dropdown dengan hasil pencarian
                        data.forEach(item => {
                            const li = document.createElement('li');
                            li.innerHTML = `<a class="dropdown-item" href="#" data-id="${item.id}" data-nis="${item.nis}" data-name="${item.nama}">${item.nis} - ${item.nama}</a>`;
                            searchDropdown.appendChild(li);
                        });
                        const dropdownItems = searchDropdown.querySelectorAll('.dropdown-item');
                        const idSiswaInput = document.getElementById('id_siswa');
                        dropdownItems.forEach(item => {
                            item.addEventListener('click', function(e) {
                                e.preventDefault(); // Cegah link default
                                const selectedNis = this.getAttribute('data-nis');
                                const selectedName = this.getAttribute('data-name');
                                const selectedId = this.getAttribute('data-id');
                                idSiswaInput.value = selectedId; // Isi input dengan ID siswa
                                searchInput.value = `${selectedNis} - ${selectedName}`; // Isi input dengan nilai yang dipilih
                                searchDropdown.innerHTML = ''; // Kosongkan dropdown setelah dipilih
                            });
                        });
                    });
            } else {
                searchDropdown.innerHTML = ''; // Kosongkan dropdown jika input terlalu pendek
            }
        });


    });
</script>