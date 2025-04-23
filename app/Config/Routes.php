<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');

$routes->group('auth', function ($routes) {
    $routes->group('sekolah', function ($routes) {
        $routes->get('login', 'Auth::index');
        $routes->post('login', 'Auth::login');
        $routes->get('logout', 'Auth::sekolahLogout');
    });
    $routes->group('admin', function ($routes) {
        $routes->get('login', 'Auth::loginAdmin');
        $routes->post('login', 'Auth::StoreLoginAdmin');
        $routes->get('logout', 'Auth::adminLogout');
    });
});

$routes->group('angkatan', function ($routes) {
    $routes->get('/', 'Angkatan::index');
    $routes->post('add', 'Angkatan::add');
    $routes->post('update-ta-active', 'Angkatan::updateTaActive');
});

$routes->group('siswa', function ($routes) {
    $routes->get('/', 'Siswa::index');
    $routes->get('search', 'Siswa::search');
    $routes->get('show/(:num)', 'Siswa::show/$1');
    $routes->get('get-siswa-angkatan/(:num)', 'Siswa::getSiswaAngkatan/$1');
    $routes->get('get-kelas-siswa/(:num)', 'Siswa::getKelasSiswa/$1');
    $routes->post('del-siswa/(:num)', 'Siswa::deleteSiswa/$1');
});

$routes->group('kelas', function ($routes) {
    $routes->get('/', 'Kelas::index');
    $routes->post('add', 'Kelas::add');
    $routes->post('update/(:num)', 'Kelas::update/$1');
    $routes->post('delete/(:num)', 'Kelas::delete/$1');
    $routes->get('get-kelas-ajax', 'Kelas::getKelasSiswa');
    $routes->get('get-kelas-ajax/(:num)', 'Kelas::getKelasSiswaByTa/$1');
    $routes->get('get-perkelas-ajax/(:num)/(:num)', 'Kelas::getKelasSiswaByKelas/$1/$2');
});

$routes->group('prestasi', function ($routes) {
    $routes->get('/', 'Prestasi::index');
    $routes->post('add', 'Prestasi::add');
    $routes->post('update', 'Prestasi::update');
    $routes->post('delete/(:num)', 'Prestasi::delete/$1');
    $routes->group('ajax', function ($routes) {
        $routes->get('get/(:num)', 'Prestasi::getPrestasiAjax/$1');
    });
});

$routes->group('sekolah', ['filter' => 'authsekolah'], function ($routes) {
    $routes->get('/', 'Sekolah\Dashboard::index');
    $routes->get('dashboard', 'Sekolah\Dashboard::index');
    $routes->get('get-siswa', 'Sekolah\Dashboard::getSiswa');
    $routes->get('get-siswa/(:num)', 'Sekolah\Dashboard::getSiswa/$1');
    $routes->post('add-siswa', 'Sekolah\Dashboard::addSiswa');
    $routes->post('edit-siswa', 'Sekolah\Dashboard::editSiswa');
    $routes->get('bulk-siswa', 'Sekolah\Dashboard::bulkSiswa');
    $routes->post('save-bulk-siswa', 'Sekolah\Dashboard::saveBulkSiswa');
    $routes->group('siswa', function ($routes) {
        $routes->get('', 'Sekolah\Dashboard::mSiswa');
        $routes->get('angkatan/(:num)', 'Sekolah\Dashboard::mSiswaByAngkatan/$1');
    });
    $routes->group('prestasi', function ($routes) {
        $routes->get('', 'Sekolah\Dashboard::mPrestasi');
        $routes->get('angkatan/(:num)', 'Sekolah\Dashboard::mPrestasiByAngkatan/$1');
    });
    $routes->group('akademis', function ($routes) {
        $routes->get('', 'Sekolah\Dashboard::mAkademis');
        $routes->get('angkatan/(:num)', 'Sekolah\Dashboard::mAkademisAngkatan/$1');
        $routes->get('get-akademis-angkatan/(:num)', 'Sekolah\Dashboard::getSiswaByAngkatan/$1');
        $routes->get('angkatan/(:num)/kelas/(:num)', 'Sekolah\Dashboard::mAkademisKelas/$1/$2');
    });
    $routes->post('upload-ijazah', 'Siswa::uploadIjazah');
    $routes->post('upload-spindah', 'Siswa::uploadSrtPindah');
    $routes->post('upload-skeluar', 'Siswa::uploadSrtKeluar');
    $routes->get('profil', 'Sekolah\Dashboard::profil');
    $routes->get('get-csv', 'Sekolah\Dashboard::getCsv');
});

$routes->group('admin', function ($routes) {
    $routes->get('/', 'Admin\Dashboard::index');
    $routes->get('dashboard', 'Admin\Dashboard::index');
    $routes->group('sekolah', function ($routes) {
        $routes->get('', 'Admin\Dashboard::mSekolah');
        $routes->get('(:num)/angkatan', 'Admin\Dashboard::mAngkatanSekolah/$1');
        $routes->get('(:num)/angkatan/(:num)', 'Admin\Dashboard::mSiswaSekolah/$1/$2');
        $routes->get('(:num)/angkatan/(:num)/siswa/', 'Admin\Dashboard::mSekolahSiswa/$1/$2');
    });
    $routes->get('siswa', 'Admin\Dashboard::mSiswa');
    $routes->get('get-siswa', 'Admin\Dashboard::getSiswa');
    $routes->get('get-sekolah', 'Admin\Dashboard::getSekolah');
    $routes->post('edit-sekolah', 'Admin\Dashboard::editSekolah');
    $routes->post('add-sekolah', 'Admin\Dashboard::addSekolah');
    $routes->post('del-sekolah/(:num)', 'Admin\Dashboard::deleteSekolah/$1');
    $routes->get('profil', 'Admin\Dashboard::profil');
    $routes->post('edit-profil', 'Admin\Dashboard::updateProfileAdminApp');
});
