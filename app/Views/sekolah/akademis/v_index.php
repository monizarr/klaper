<!-- Page header -->
<div class="page-header d-print-none">
    <div class="container-xl">
        <div class="row g-2 align-items-center">
            <div class="col">
                <!-- Page pre-title -->
                <div class="page-pretitle">
                    <?= $user["sekolah"]["nama"] ?>
                </div>
                <h2 class="page-title">
                    <?= isset($title) ? $title : 'Data Siswa' ?>
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
        <div class="row row-deck row-cards mb-4">
            <div class="col-12">
                <div class="card">
                    <div class="card-header ">
                        <h3 class="card-title">Pilih Tahun Ajaran</h3>
                    </div>
                    <div class="card-body row">
                        <?php foreach ($angkatan as $a) : ?>
                            <div class="col-4 btn-group mb-3">
                                <a href="<?= site_url('/sekolah/akademis/angkatan/' . $a['angkatan']) ?>" class="card card-primary py-3 fs-3 text-center text-decoration-none " style="border: 1px solid #066fd1a6; border-radius: 4px; box-sizing: border-box;">
                                    <h2>
                                        <?= $a['angkatan'] ?>
                                    </h2>
                                    <span>
                                        Jumlah Siswa
                                        <span class="badge bg-primary ms-2 text-white">
                                            <?= $a['jumlah_siswa'] ?>
                                        </span>
                                    </span>
                                </a>
                            </div>
                        <?php endforeach ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal tambah siswa -->
<div class="modal modal-blur fade" id="modal-siswa" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <form action="<?= site_url('/sekolah/add-siswa') ?>" method="post" class="modal-content" enctype="multipart/form-data">
            <div class="modal-header">
                <h5 class="modal-title">Tambah Siswa</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <input type="text" hidden name="id_sekolah" value="<?= $user["sekolah"]["id"] ?>">
                <!-- status masuk -->
                <div class="mb-3">
                    <label class="form-label w-100">Status Masuk</label>
                    <select class="form-select" name="status_masuk" id="status_masuk" required>
                        <option value="ppdb" selected>PPDB</option>
                        <option value="pindahan">Pindahan</option>
                    </select>
                </div>
                <div class="mb-3">
                    <label class="form-label">NIS</label>
                    <input type="number" class="form-control" name="nis" required placeholder="Nomor Induk Siswa">
                </div>
                <div class="mb-3">
                    <label class="form-label">Nama</label>
                    <input type="text" class="form-control" name="nama" required placeholder="Masukan nama lengkap">
                </div>
                <div class="mb-3">
                    <label class="form-label">Jenis Kelamin</label>
                    <select class="form-select" name="jk" required>
                        <option value="L" selected>L</option>
                        <option value="P">P</option>
                    </select>
                </div>
                <div class="row mb-3">
                    <div class="col-lg-6">
                        <label class="form-label">Tempat Lahir</label>
                        <input type="text" class="form-control" name="tempat_lahir" required placeholder="Tempat Lahir">
                    </div>
                    <div class="col-lg-6">
                        <label class="form-label">Tanggal Lahir</label>
                        <input type="date" class="form-control" required name="tgl_lahir">
                    </div>
                </div>
                <!-- default kode siswa masuk : 1 -->
                <input type="text" hidden name="status_masuk" value="1">
                <div class="mb-3">
                    <label class="form-label">Orang Tua</label>
                    <input type="text" class="form-control" name="ortu" required placeholder="Nama Ayah / Ibu">
                </div>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="mb-3">
                            <label class="form-label">Tahun Masuk</label>
                            <input type="number" min="1900" max="2099" step="1" value="<?php echo date('Y'); ?>" name="masuk" class="form-control" required>
                        </div>
                        <div class="mb-3" id="surat_pindah" style="display: none;">
                            <label class="form-label w-100">Surat Pindah</label>
                            <input type="file" class="form-control" name="bukti_masuk">
                        </div>
                    </div>
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

<?php foreach ($siswa as $s) : ?>
    <div class="modal fade" id="modal-edit-<?= $s['id'] ?>" tabindex="-1" aria-labelledby="modal-edit-label-<?= $s['id'] ?>" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modal-edit-label-<?= $s['id'] ?>">Edit Siswa</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <ul class="nav nav-tabs" id="tabs-<?= $s['id'] ?>" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="tabs-profile-tab-<?= $s['id'] ?>" data-bs-toggle="tab" data-bs-target="#tabs-profile-<?= $s['id'] ?>" type="button" role="tab" aria-controls="tabs-profile-<?= $s['id'] ?>" aria-selected="false">Riwayat Akademis</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="tabs-lulus-tab-<?= $s['id'] ?>" data-bs-toggle="tab" data-bs-target="#tabs-lulus-<?= $s['id'] ?>" type="button" role="tab" aria-controls="tabs-lulus-<?= $s['id'] ?>" aria-selected="true">Siswa Lulus</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="tabs-pindah-tab-<?= $s['id'] ?>" data-bs-toggle="tab" data-bs-target="#tabs-pindah-<?= $s['id'] ?>" type="button" role="tab" aria-controls="tabs-pindah-<?= $s['id'] ?>" aria-selected="false">Siswa Pindah</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="tabs-keluar-tab-<?= $s['id'] ?>" data-bs-toggle="tab" data-bs-target="#tabs-keluar-<?= $s['id'] ?>" type="button" role="tab" aria-controls="tabs-keluar-<?= $s['id'] ?>" aria-selected="false">Siswa Putus Sekolah</button>
                        </li>
                    </ul>
                    <div class="tab-content" id="tabs-content-<?= $s['id'] ?>">

                        <div class="tab-pane fade show active" id="tabs-profile-<?= $s['id'] ?>" role="tabpanel" aria-labelledby="tabs-profile-tab-<?= $s['id'] ?>">
                            <div class="mt-4" id="academic-history-<?= $s['id'] ?>">Memuat data...</div>
                        </div>
                        <div class="tab-pane fade" id="tabs-lulus-<?= $s['id'] ?>" role="tabpanel" aria-labelledby="tabs-lulus-tab-<?= $s['id'] ?>">
                            <form action="<?= site_url('/sekolah/upload-ijazah'); ?>" method="post" enctype="multipart/form-data">
                                <?= csrf_field() ?>
                                <!-- <div class="modal-header">
                                    <h5 class="modal-title">Edit Siswa</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div> -->
                                <div class="modal-body">
                                    <input type="text" hidden name="id" value="<?= $s['id'] ?>" required>
                                    <div class="col-lg-12">
                                        <div class="mb-3">
                                            <label class="form-label w-100">Ijazah</label>
                                            <input type="file" class="form-control" name="bukti_keluar">
                                        </div>
                                    </div>
                                    <!-- submit -->
                                    <button type="submit" class="btn btn-primary ms-auto" <?= ($s['status_keluar'] != 'lulus' && $s['status_keluar'] != null) ? 'disabled' : '' ?>>
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-edit">
                                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                            <path d="M7 7h-1a2 2 0 0 0 -2 2v9a2 2 0 0 0 2 2h9a2 2 0 0 0 2 -2v-1" />
                                            <path d="M20.385 6.585a2.1 2.1 0 0 0 -2.97 -2.97l-8.415 8.385v3h3l8.385 -8.415z" />
                                            <path d="M16 5l3 3" />
                                        </svg>
                                        Simpan
                                    </button>
                                </div>
                                <!-- <div class="modal-footer">
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
                                </div> -->
                            </form>
                        </div>
                        <div class="tab-pane fade" id="tabs-pindah-<?= $s['id'] ?>" role="tabpanel" aria-labelledby="tabs-pindah-tab-<?= $s['id'] ?>">
                            <form action="<?= site_url('/sekolah/upload-spindah'); ?>" method="post" enctype="multipart/form-data">
                                <?= csrf_field() ?>
                                <!-- <div class="modal-header">
                                    <h5 class="modal-title">Edit Siswa</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div> -->
                                <div class="modal-body">
                                    <input type="text" hidden name="id" value="<?= $s['id'] ?>">
                                    <div class="col-lg-12">
                                        <div class="mb-3">
                                            <label class="form-label w-100">Surat Pindah</label>
                                            <input type="file" class="form-control" name="bukti_keluar">
                                        </div>
                                    </div>
                                    <!-- submit -->
                                    <button type="submit" class="btn btn-primary ms-auto" <?= ($s['status_keluar'] != 'pindah' && $s['status_keluar'] != null) ? 'disabled' : '' ?>>
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-edit">
                                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                            <path d="M7 7h-1a2 2 0 0 0 -2 2v9a2 2 0 0 0 2 2h9a2 2 0 0 0 2 -2v-1" />
                                            <path d="M20.385 6.585a2.1 2.1 0 0 0 -2.97 -2.97l-8.415 8.385v3h3l8.385 -8.415z" />
                                            <path d="M16 5l3 3" />
                                        </svg>
                                        Simpan
                                    </button>
                                </div>
                            </form>
                        </div>
                        <div class="tab-pane fade" id="tabs-keluar-<?= $s['id'] ?>" role="tabpanel" aria-labelledby="tabs-keluar-tab-<?= $s['id'] ?>">
                            <form action="<?= site_url('/sekolah/upload-skeluar'); ?>" method="post" enctype="multipart/form-data">
                                <?= csrf_field() ?>
                                <div class="modal-body">
                                    <input type="text" hidden name="id" value="<?= $s['id'] ?>">
                                    <div class="col-lg-12">
                                        <div class="mb-3">
                                            <label class="form-label w-100">Surat Keterangan Putus Sekolah</label>
                                            <input type="file" class="form-control" name="bukti_keluar">
                                        </div>
                                    </div>
                                    <!-- submit -->
                                    <button type="submit" class="btn btn-primary ms-auto" <?= ($s['status_keluar'] != 'pindah' && $s['status_keluar'] != null) ? 'disabled' : '' ?>>
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-edit">
                                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                            <path d="M7 7h-1a2 2 0 0 0 -2 2v9a2 2 0 0 0 2 2h9a2 2 0 0 0 2 -2v-1" />
                                            <path d="M20.385 6.585a2.1 2.1 0 0 0 -2.97 -2.97l-8.415 8.385v3h3l8.385 -8.415z" />
                                            <path d="M16 5l3 3" />
                                        </svg>
                                        Simpan
                                    </button>
                                </div>
                            </form>
                        </div>

                    </div>
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
                    const isDo = data[data.length - 1]['bukti'] != null && data[data.length - 1]['status_keluar'] == 'do';

                    if (Array.isArray(data) && data.length > 0) {
                        targetDiv.innerHTML = `
                        <div class="mt-4 row">
                            <form method="post" class="col-md-6" action="<?= site_url('/kelas/add') ?>" >
                                <input type="text" hidden class="form-control" name="id_siswa" required value="${siswaId}" placeholder="Tahun Ajaran">
                                <input type="text" hidden class="form-control" name="id_sekolah" required value="<?= $user['sekolah']['id'] ?>" placeholder="Tahun Ajaran">
                                <div class="row" hidden>
                                    <div class="col-lg-6">
                                        <div class="mb-3">
                                            <label class="form-label">Kelas</label>
                                            <input type="text" class="form-control" name="kelas" required placeholder="Kelas" value="${kelasPlus}">
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="mb-3">
                                            <label class="form-label">Tahun Ajaran</label>
                                            <input type="text" class="form-control" name="ta" required placeholder="Tahun Ajaran" value="<?= date('Y') ?>">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-12">
                                    <div class="mb-3">
                                        <button type="submit" class="btn btn-primary w-full" ${isLulus || isPindah ||isDo ? 'disabled' : ''}>
                                        <svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-arrow-badge-up"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M17 11v6l-5 -4l-5 4v-6l5 -4z" /></svg>
                                        Naik Kelas
                                        </button>
                                    </div>
                                </div>
                            </form>
                            
                            <form method="post" class="col-md-6 mb-2" action="<?= site_url('/kelas/add') ?>" >
                                <input type="text" hidden class="form-control" name="id_siswa" required value="${siswaId}" placeholder="Tahun Ajaran">
                                <input type="text" hidden class="form-control" name="id_sekolah" required value="<?= $user['sekolah']['id'] ?>" placeholder="Tahun Ajaran">
                                <div class="row" hidden>
                                    <div class="col-lg-6">
                                        <div class="mb-3">
                                            <label class="form-label">Kelas</label>
                                            <input type="text" class="form-control" name="kelas" required placeholder="Kelas" value="${kelasTerakhir}">
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="mb-3">
                                            <label class="form-label">Tahun Ajaran</label>
                                            <input type="text" class="form-control" name="ta" required placeholder="Tahun Ajaran" value="<?= date('Y') ?>">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-12">
                                    <div class="mb-3">
                                        <button type="submit" class="btn btn-primary w-full" ${isLulus || isPindah ||isDo ? 'disabled' : ''} >
                                        <svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-arrow-badge-down"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M17 13v-6l-5 4l-5 -4v6l5 4z" /></svg>
                                        Tinggal Kelas
                                        </button>
                                    </div>
                                </div>
                            </form>

                            <hr />
                            <h4>Riwayat Kelas</h4>
                            <table class="table table-bordered table-striped mt-2" id="table-riwayat-${siswaId}">
                                <thead>
                                    <tr>
                                        <th>Kelas</th>
                                        <th>Tahun Ajaran</th>
                                        <th>Aksi</th>
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
                                        <td>
                                            <button 
                                                class="btn btn-primary" 
                                                onclick="updateRow(${item.id})">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon m-0 icon-tabler icons-tabler-outline icon-tabler-edit">
                                                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                    <path d="M7 7h-1a2 2 0 0 0 -2 2v9a2 2 0 0 0 2 2h9a2 2 0 0 0 2 -2v-1" />
                                                    <path d="M20.385 6.585a2.1 2.1 0 0 0 -2.97 -2.97l-8.415 8.385v3h3l8.385 -8.415z" />
                                                    <path d="M16 5l3 3" />
                                                </svg>
                                            </button>
                                            <button 
                                                class="btn btn-neutral" 
                                                onclick="deleteRow(${item.id})">
                                                <svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon m-0 icon-tabler icons-tabler-outline icon-tabler-trash"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M4 7l16 0" /><path d="M10 11l0 6" /><path d="M14 11l0 6" /><path d="M5 7l1 12a2 2 0 0 0 2 2h8a2 2 0 0 0 2 -2l1 -12" /><path d="M9 7v-3a1 1 0 0 1 1 -1h4a1 1 0 0 1 1 1v3" /></svg>
                                                </svg>
                                            </button>
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

    // $(document).ready(function() {
    //     let table = $('#userTable').DataTable({
    //         "processing": true,
    //         "serverSide": true,
    //         "ajax": {
    //             "url": "<?= site_url('/kelas/get-kelas-ajax') ?>",
    //             "type": "GET",
    //             "data": function(d) {
    //                 d.angkatan = $('#dropdown-angkatan').attr('data-selected'); // Tambahkan parameter angkatan
    //             }
    //         },
    //         "columns": [{
    //                 "data": "kelas"
    //             },
    //             {
    //                 "data": "nis"
    //             },
    //             {
    //                 "data": "nama"
    //             },
    //             {
    //                 "data": "ta"
    //             },
    //             {
    //                 "data": "siswa_id",
    //                 "render": function(data, type, row) {
    //                     return `
    //                 <a href="#" class="btn btn-sm btn-primary" 
    //                     data-bs-toggle="modal" 
    //                     data-bs-target="#modal-edit-${data}" 
    //                     data-id="${data}" 
    //                     data-nis="${row.nis}" 
    //                     data-nama="${row.nama}" 
    //                     data-jk="${row.jk}" 
    //                     data-ortu="${row.orang_tua}">
    //                     Edit
    //                 </a>
    //                 <a href="#" class="btn btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#modal-confirm-delete" data-id="${data}" data-nis="${row.nis}" data-nama="${row.nama}">Delete</a>`;
    //                 }
    //             },
    //         ],
    //         "order": [
    //             [0, 'asc']
    //         ]
    //     });

    //     // Event listener untuk dropdown
    //     $('.dropdown-menu a').on('click', function(e) {
    //         e.preventDefault();

    //         // Dapatkan nilai angkatan dari item yang diklik
    //         let selectedAngkatan = $(this).text();

    //         // Tampilkan angkatan yang dipilih di tombol dropdown
    //         $('#dropdown-angkatan').text(selectedAngkatan).attr('data-selected', selectedAngkatan);

    //         // Reload data DataTable dengan parameter baru
    //         table.ajax.reload();
    //     });

    // });
</script>