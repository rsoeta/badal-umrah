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

    // Tambahkan 2 baris ini:
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
