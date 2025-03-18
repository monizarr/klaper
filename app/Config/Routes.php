<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');

$routes->group('siswa', function ($routes) {
    $routes->get('/', 'Siswa::index');
    $routes->get('show/(:num)', 'Siswa::show/$1');
    $routes->get('get-kelas-siswa/(:num)', 'Siswa::getKelasSiswa/$1');
    $routes->post('del-siswa/(:num)', 'Siswa::deleteSiswa/$1');
});

$routes->group('kelas', function ($routes) {
    $routes->get('/', 'Kelas::index');
    $routes->post('add', 'Kelas::add');
    $routes->post('update/(:num)', 'Kelas::update/$1');
    $routes->post('delete/(:num)', 'Kelas::delete/$1');
});

$routes->group('sekolah', function ($routes) {
    $routes->get('/', 'Sekolah\Dashboard::index');
    $routes->get('login', 'Auth::index');
    $routes->post('login', 'Auth::login');
    $routes->get('logout', 'Auth::sekolahLogout');
    $routes->get('dashboard', 'Sekolah\Dashboard::index');
    $routes->get('get-siswa', 'Sekolah\Dashboard::getSiswa');
    $routes->get('get-siswa/(:num)', 'Sekolah\Dashboard::getSiswa/$1');
    $routes->post('add-siswa', 'Sekolah\Dashboard::addSiswa');
    $routes->post('edit-siswa', 'Sekolah\Dashboard::editSiswa');
    $routes->get('bulk-siswa', 'Sekolah\Dashboard::bulkSiswa');
    $routes->post('save-bulk-siswa', 'Sekolah\Dashboard::saveBulkSiswa');
    $routes->get('siswa', 'Sekolah\Dashboard::mSiswa');
    $routes->post('upload-ijazah', 'Siswa::uploadIjazah');
    $routes->post('upload-spindah', 'Siswa::uploadSrtPindah');
    $routes->post('upload-skeluar', 'Siswa::uploadSrtKeluar');
    $routes->get('profil', 'Sekolah\Dashboard::profil');
    $routes->get('get-csv', 'Sekolah\Dashboard::getCsv');
});

$routes->group('admin', function ($routes) {
    $routes->get('/', 'Admin\Dashboard::index');
    $routes->get('login', 'Auth::loginAdmin');
    $routes->post('login', 'Auth::StoreLoginAdmin');
    $routes->get('logout', 'Auth::adminLogout');
    $routes->get('dashboard', 'Admin\Dashboard::index');
    $routes->get('sekolah', 'Admin\Dashboard::mSekolah');
    $routes->get('siswa', 'Admin\Dashboard::mSiswa');
    $routes->get('get-siswa', 'Admin\Dashboard::getSiswa');
    $routes->get('get-sekolah', 'Admin\Dashboard::getSekolah');
    $routes->post('edit-sekolah', 'Admin\Dashboard::editSekolah');
    $routes->post('add-sekolah', 'Admin\Dashboard::addSekolah');
    $routes->post('del-sekolah/(:num)', 'Admin\Dashboard::deleteSekolah/$1');
    $routes->get('profil', 'Admin\Dashboard::profil');
    $routes->post('edit-profil', 'Admin\Dashboard::updateProfileAdminApp');
});
