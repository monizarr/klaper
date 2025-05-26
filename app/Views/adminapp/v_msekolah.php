<!-- Page header -->
<div class="page-header d-print-none">
    <div class="container-xl">
        <div class="row g-2 align-items-center">
            <div class="col">
                <!-- Page pre-title -->
                <div class="page-pretitle">
                    <?= $user["username"] ?>
                </div>
                <h2 class="page-title">
                    Manajemen Sekolah
                </h2>
            </div>
            <!-- Page title actions -->
            <div class="col-auto ms-auto d-print-none">
                <div class="btn-list">
                    <a href="#" class="btn btn-primary d-none d-sm-inline-block" data-bs-toggle="modal" data-bs-target="#modal-siswa">
                        <!-- Download SVG icon from http://tabler-icons.io/i/plus -->
                        <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                            <path d="M12 5l0 14" />
                            <path d="M5 12l14 0" />
                        </svg>
                        Tambah Sekolah
                    </a>
                    <a href="#" class="btn btn-primary d-sm-none btn-icon" data-bs-toggle="modal" data-bs-target="#modal-siswa" aria-label="Create new report">
                        <!-- Download SVG icon from http://tabler-icons.io/i/plus -->
                        <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                            <path d="M12 5l0 14" />
                            <path d="M5 12l14 0" />
                        </svg>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Page body -->
<div class="page-body">
    <div class="container-xl">
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
                        <table id="sekolahTable" class="display">
                            <thead>
                                <tr>
                                    <th>Nama</th>
                                    <th>Email</th>
                                    <th>Telp</th>
                                    <th>Kepala Sekolah</th>
                                    <th>Akreditasi</th>
                                    <th>Created At</th>
                                    <th>Updated At</th>
                                    <th>Action</th>
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

<!-- Modal tambah sekolah -->
<div class="modal modal-blur fade" id="modal-siswa" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <form action="<?= site_url('/admin/add-sekolah') ?>" method="post" class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Tambah Sekolah</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="mb-3">
                    <label class="form-label">Nama Sekolah</label>
                    <input type="text" class="form-control" name="nama" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Userename</label>
                    <input type="text" class="form-control" name="username">
                </div>
                <div class="mb-3">
                    <label class="form-label">Password</label>
                    <input type="password" class="form-control" name="password">
                </div>
                <div class="mb-3">
                    <label class="form-label">Telp</label>
                    <input type="text" class="form-control" name="telp">
                </div>
                <div class="mb-3">
                    <label class="form-label">NPSN</label>
                    <input type="number" class="form-control" name="npsn">
                </div>
                <div class="mb-3">
                    <label class="form-label">Email</label>
                    <input type="email" class="form-control" name="email">
                </div>
                <div class="mb-3">
                    <label class="form-label">Alamat</label>
                    <input type="text" class="form-control" name="alamat" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Kepala Sekolah</label>
                    <input type="text" class="form-control" name="kepsek" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Akreditasi</label>
                    <select class="form-select" name="akreditasi" required>
                        <option value="">Pilih Akreditasi</option>
                        <option value="A">A</option>
                        <option value="B">B</option>
                        <option value="C">C</option>
                        <option value="Tidak Terakreditasi">Tidak Terakreditasi</option>
                    </select>
                </div>
            </div>
            <div class="modal-footer">
                <a href="#" class="btn btn-link link-secondary" data-bs-dismiss="modal">
                    Cancel
                </a>
                <button type="submit" class="btn btn-primary ms-auto">
                    <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                        <path d="M12 5l0 14" />
                        <path d="M5 12l14 0" />
                    </svg>
                    Simpan
                </button>
            </div>
        </form>
    </div>
</div>

<!-- Modal edit sekolah -->
<?php foreach ($sekolah as $s) : ?>
    <div class="modal modal-blur fade" id="modal-sekolah-edit-<?= $s['id'] ?>" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <form action="<?= site_url('/admin/edit-sekolah') ?>" method="post" class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Edit Sekolah</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="id" value="<?= $s['id'] ?>">
                    <div class="mb-3">
                        <label class="form-label">Nama Sekolah</label>
                        <input type="text" class="form-control" name="nama" value="<?= $s['nama'] ?>" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Username</label>
                        <input type="text" class="form-control" name="username" value="<?= $s['username'] ?>">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Password</label>
                        <input type="text" class="form-control" name="password">
                        <small>
                            *Kosongkan jika tidak ingin mengganti password
                        </small>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">NPSN</label>
                        <input type="text" class="form-control" name="npsn" value="<?= $s['npsn'] ?>">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Telp</label>
                        <input type="text" class="form-control" name="telp" value="<?= $s['telp'] ?>">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Email</label>
                        <input type="email" class="form-control" name="email" value="<?= $s['email'] ?>">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Alamat</label>
                        <input type="text" class="form-control" name="alamat" value="<?= $s['alamat'] ?>" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Kepala Sekolah</label>
                        <input type="text" class="form-control" name="kepsek" value="<?= $s['kepsek'] ?>" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Akreditasi</label>
                        <select class="form-select" name="akreditasi" required>
                            <option value="">Pilih Akreditasi</option>
                            <option value="A" <?= $s['akreditasi'] == 'A' ? 'selected' : '' ?>>A</option>
                            <option value="B" <?= $s['akreditasi'] == 'B' ? 'selected' : '' ?>>B</option>
                            <option value="C" <?= $s['akreditasi'] == 'C' ? 'selected' : '' ?>>C</option>
                            <option value="Tidak Terakreditasi" <?= $s['akreditasi'] == 'Tidak Terakreditasi' ? 'selected' : '' ?>>Tidak Terakreditasi</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <a href="#" class="btn btn-link link-secondary" data-bs-dismiss="modal">
                        Cancel
                    </a>
                    <button type="submit" class="btn btn-primary ms-auto">
                        <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                            <path d="M12 5l0 14" />
                            <path d="M5 12l14 0" />
                        </svg>
                        Simpan
                    </button>
                </div>
            </form>
        </div>
    </div>
<?php endforeach; ?>


<!-- modal delete sekolah -->
<div class="modal fade" id="modal-confirm-delete" tabindex="-1" aria-labelledby="modal-confirm-delete-label" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <form id="deleteForm" method="post">
                <div class="modal-header">
                    <h5 class="modal-title" id="modal-confirm-delete-label">Perbarui Status Sekolah</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>Anda akan mengubah status data <strong id="nisText"></strong></p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-link link-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-danger">Ubah</button>
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
        $('#deleteForm').attr('action', `<?= site_url('/admin/del-sekolah/') ?>${id}`);
    });

    $(document).ready(function() {
        $('#sekolahTable').DataTable({
            "processing": true,
            "serverSide": true,
            "ajax": {
                "url": "<?= site_url('/admin/get-sekolah') ?>",
                "type": "GET"
            },
            "columns": [{
                    "data": "nama"
                },
                {
                    "data": "email"
                },
                {
                    "data": "telp"
                },
                {
                    "data": "kepsek"
                },
                {
                    "data": "akreditasi"
                },
                {
                    "data": "created_at"
                },
                {
                    "data": "updated_at"
                },
                {
                    "data": "id",
                    "render": function(data, type, row) {
                        const status = row.status == 'a' ? 'Aktif' : 'Non-aktif';
                        const btnColor = row.status == 'a' ? 'btn-danger' : 'btn-primary-outline';

                        return `<a href="#" class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#modal-sekolah-edit-${row.id}">Edit</a>
                        <a href="#" class="btn btn-sm ${btnColor}" data-bs-toggle="modal" data-bs-target="#modal-confirm-delete" data-id="${data}" data-nis="${row.nis}" data-nama="${row.nama}">
                            ${status == 'Aktif' ? 'Non-aktifkan' : 'Aktifkan'}
                        </a>`;

                    }
                }
            ],
            // order
            "order": [
                [0, 'asc']
            ],
        });
    });

    $(document).on('click', '[data-bs-target="#modal-sekolah-delete"]', function() {
        const id = $(this).data('id');
        const nama = $(this).data('nama');

        $('#sekolahText').text(nama);
        $('#deleteForm').attr('action', `<?= site_url('/admin/del-sekolah/') ?>${id}`);
    });
</script>