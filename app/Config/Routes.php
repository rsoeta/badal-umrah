<?php

use CodeIgniter\Router\RouteCollection;

/** @var RouteCollection $routes */
$routes->get('/', 'Home::index');

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
    $routes->post('pendaftaran/(:num)/hapus', 'AdminController::hapusPendaftaran/$1');
    $routes->post('pendaftaran/(:num)/restore', 'AdminController::restorePendaftaran/$1');
    $routes->post('pendaftaran/(:num)/hapus-permanen', 'AdminController::hapusPermanen/$1');
    $routes->get('pendaftaran/(:num)/videos', 'AdminController::daftarVideo/$1');
    $routes->post('pendaftaran/(:num)/videos', 'AdminController::unggahVideo/$1');
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
