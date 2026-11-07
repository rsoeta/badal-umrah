<?php

use CodeIgniter\Router\RouteCollection;

/** @var RouteCollection $routes */
$routes->get('/', 'Home::index');
$routes->get('video/(:segment)', 'PendaftaranController::tontonVideo/$1');
$routes->get('video/(:segment)/stream', 'PendaftaranController::streamVideo/$1');
$routes->get('video/(:segment)/download', 'PendaftaranController::downloadSharedVideo/$1');

// Rute Login
$routes->get('login', 'AuthController::index');
$routes->post('login/proses', 'AuthController::proses');
$routes->get('logout', 'AuthController::logout');

// Rute Admin (Dikunci dengan AuthFilter)
$routes->group('admin', ['filter' => 'auth'], function ($routes) {
    $routes->get('/', 'AdminController::index');
    $routes->post('proses-sertifikat', 'AdminController::prosesSertifikat');
    $routes->get('sampah', 'AdminController::sampah');
    $routes->post('pendaftaran/(:num)/edit', 'AdminController::editPendaftaran/$1');
    $routes->get('pendaftaran/(:num)/foto', 'AdminController::lihatFoto/$1');
    $routes->post('pendaftaran/(:num)/hapus', 'AdminController::hapusPendaftaran/$1');
    $routes->post('pendaftaran/(:num)/restore', 'AdminController::restorePendaftaran/$1');
    $routes->post('pendaftaran/(:num)/hapus-permanen', 'AdminController::hapusPermanen/$1');
    $routes->get('pendaftaran/(:num)/videos', 'AdminController::daftarVideo/$1');
    $routes->post('pendaftaran/(:num)/videos', 'AdminController::unggahVideo/$1');
    $routes->post('pendaftaran/(:num)/videos/(:num)/share', 'AdminController::bagikanVideo/$1/$2');
    $routes->post('pendaftaran/(:num)/videos/(:num)/unshare', 'AdminController::cabutBagikanVideo/$1/$2');
    $routes->get('pendaftaran/(:num)/videos/(:num)/download', 'AdminController::unduhVideo/$1/$2');
    $routes->post('pendaftaran/(:num)/videos/(:num)/hapus', 'AdminController::hapusVideo/$1/$2');

    $routes->get('pengaturan', 'AdminController::pengaturan');
    $routes->post('pengaturan/simpan', 'AdminController::simpanPengaturan');
});

$routes->get('sertifikat', 'SertifikatController::index');
$routes->post('sertifikat/generate', 'SertifikatController::generate');

// Halaman Form Pendaftaran
$routes->get('pendaftaran', 'PendaftaranController::index');
$routes->post('pendaftaran/submit', 'PendaftaranController::submit');

// Rute Cek Sertifikat (Frontend)
$routes->post('cek-sertifikat', 'PendaftaranController::cekSertifikat');

$routes->get('favicon.ico', static function () {
    $path = FCPATH . 'favicon.ico';
    if (! is_file($path)) {
        return service('response')->setStatusCode(404);
    }

    return service('response')
        ->setContentType('image/x-icon')
        ->setHeader('Cache-Control', 'public, max-age=3600, must-revalidate')
        ->setBody(file_get_contents($path));
});
