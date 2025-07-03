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
                    <?= $title ?>
                </h2>
            </div>
            <!-- Page title actions -->
            <div class="col-auto ms-auto d-print-none">
                <div class="btn-list">
                    <a href="#" class="btn btn-primary d-none d-sm-inline-block" data-bs-toggle="modal" data-bs-target="#modal-siswa">
                        <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                            <path d="M12 5l0 14" />
                            <path d="M5 12l14 0" />
                        </svg>
                        Tambah Angkatan
                    </a>
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
        <div class="flash-data" data-flashdata="<?= session()->getFlashdata('message'); ?>"></div>
        <div class="row row-deck row-cards">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <form action="<?= site_url('/angkatan/update-ta-active') ?>" method="post" enctype="multipart/form-data" class="d-flex justify-content-center align-items-end gap-3">
                            <div class="" style="width: -webkit-fill-available;">
                                <label class="form-label">Tahun Ajaran Aktif</label>
                                <select class="form-select" name="taAktif" required>
                                    <option value="" selected disabled>Pilih Tahun Ajaran</option>
                                    <?php foreach ($angkatan as $a) : ?>
                                        <option value="<?= $a['id'] ?>"
                                            <?= ($a['status'] == 1) ? 'selected' : '' ?>
                                            <?= ($a['status'] == 1) ? 'disabled' : '' ?>
                                            <?= ($a['status'] == 1) ? 'style="background-color: #d1e7dd;"' : '' ?>
                                            <?= ($a['status'] == 1) ? 'style="color: #0f5132;"' : '' ?>
                                            <?= ($a['status'] == 1) ? 'style="font-weight: bold;"' : '' ?>>
                                            <?= $a['angkatan'] ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <div class="">
                                <button type="submit" class="btn btn-primary">Simpan</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal tambah siswa -->
<div class="modal modal-blur fade" id="modal-siswa" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <form action="<?= site_url('/angkatan/add') ?>" method="post" class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Tambah Angkatan</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <input type="text" hidden name="id_sekolah" value="<?= $user["sekolah"]["id"] ?>">
                <div class="mb-3">
                    <label class="form-label">Angkatan</label>
                    <input type="number" class="form-control" name="angkatan" required placeholder="Tahun Angkatan">
                </div>
                <div class="mb-3">
                    <label class="form-label">Deskripsi</label>
                    <textarea type="text" class="form-control" name="deskripsi" placeholder="Deskripsi"></textarea>
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

<script>

</script>