<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index', ['filter' => 'auth']);

// Auth Routes
$routes->get('/login', 'AuthController::login');
$routes->post('/login/attempt', 'AuthController::attemptLogin');
$routes->get('/logout', 'AuthController::logout');

// User Management Routes
$routes->get('/users', 'UserController::index', ['filter' => 'auth']);
$routes->post('/users/datatable', 'UserController::datatable', ['filter' => 'auth']);
$routes->get('/users/get/(:num)', 'UserController::get/$1', ['filter' => 'auth']);
$routes->get('/users/get-roles', 'UserController::getRoles', ['filter' => 'auth']);
$routes->post('/users/save', 'UserController::save', ['filter' => 'auth']);
$routes->post('/users/delete/(:num)', 'UserController::delete/$1', ['filter' => 'auth']);
$routes->get('/users/create', 'UserController::create', ['filter' => 'auth']);
$routes->post('/users/store', 'UserController::store', ['filter' => 'auth']);
$routes->get('/users/edit/(:num)', 'UserController::edit/$1', ['filter' => 'auth']);
$routes->post('/users/update/(:num)', 'UserController::update/$1', ['filter' => 'auth']);

// Pasien Routes
$routes->get('/pasien', 'PasienController::index', ['filter' => 'auth']);
$routes->post('/pasien/datatable', 'PasienController::datatable', ['filter' => 'auth']);
$routes->get('/pasien/get/(:num)', 'PasienController::get/$1', ['filter' => 'auth']);
$routes->post('/pasien/save', 'PasienController::save', ['filter' => 'auth']);
$routes->post('/pasien/delete/(:num)', 'PasienController::delete/$1', ['filter' => 'auth']);
$routes->get('/pasien/pdf/(:num)', 'PasienController::pdf/$1', ['filter' => 'auth']);
$routes->get('/pasien/pdf-rekap', 'PasienController::pdfRekap', ['filter' => 'auth']);
$routes->get('/pasien/create', 'PasienController::create', ['filter' => 'auth']);
$routes->post('/pasien/store', 'PasienController::store', ['filter' => 'auth']);
$routes->get('/pasien/edit/(:num)', 'PasienController::edit/$1', ['filter' => 'auth']);
$routes->post('/pasien/update/(:num)', 'PasienController::update/$1', ['filter' => 'auth']);

// Pendaftaran Routes
$routes->get('/pendaftaran', 'PendaftaranController::index', ['filter' => 'auth']);
$routes->post('/pendaftaran/datatable', 'PendaftaranController::datatable', ['filter' => 'auth']);
$routes->get('/pendaftaran/get/(:num)', 'PendaftaranController::get/$1', ['filter' => 'auth']);
$routes->get('/pendaftaran/get-pasien-list', 'PendaftaranController::getPasienList', ['filter' => 'auth']);
$routes->post('/pendaftaran/save', 'PendaftaranController::save', ['filter' => 'auth']);
$routes->post('/pendaftaran/delete/(:num)', 'PendaftaranController::delete/$1', ['filter' => 'auth']);
$routes->get('/pendaftaran/pdf/(:num)', 'PendaftaranController::pdf/$1', ['filter' => 'auth']);
$routes->get('/pendaftaran/pdf-rekap', 'PendaftaranController::pdfRekap', ['filter' => 'auth']);
$routes->get('/pendaftaran/create', 'PendaftaranController::create', ['filter' => 'auth']);
$routes->post('/pendaftaran/store', 'PendaftaranController::store', ['filter' => 'auth']);

// Kunjungan Routes
$routes->get('/kunjungan', 'KunjunganController::index', ['filter' => 'auth']);
$routes->post('/kunjungan/datatable', 'KunjunganController::datatable', ['filter' => 'auth']);
$routes->get('/kunjungan/get/(:num)', 'KunjunganController::get/$1', ['filter' => 'auth']);
$routes->get('/kunjungan/get-pendaftaran-list', 'KunjunganController::getPendaftaranList', ['filter' => 'auth']);
$routes->post('/kunjungan/save', 'KunjunganController::save', ['filter' => 'auth']);
$routes->post('/kunjungan/delete/(:num)', 'KunjunganController::delete/$1', ['filter' => 'auth']);
$routes->get('/kunjungan/pdf/(:num)', 'KunjunganController::pdf/$1', ['filter' => 'auth']);
$routes->get('/kunjungan/pdf-rekap', 'KunjunganController::pdfRekap', ['filter' => 'auth']);

// Asesmen Routes
$routes->get('/asesmen', 'AsesmenController::index', ['filter' => 'auth']);
$routes->post('/asesmen/datatable', 'AsesmenController::datatable', ['filter' => 'auth']);
$routes->get('/asesmen/get/(:num)', 'AsesmenController::get/$1', ['filter' => 'auth']);
$routes->get('/asesmen/get-kunjungan-list', 'AsesmenController::getKunjunganList', ['filter' => 'auth']);
$routes->post('/asesmen/save', 'AsesmenController::save', ['filter' => 'auth']);
$routes->post('/asesmen/delete/(:num)', 'AsesmenController::delete/$1', ['filter' => 'auth']);
$routes->get('/asesmen/pdf/(:num)', 'AsesmenController::pdf/$1', ['filter' => 'auth']);
$routes->get('/asesmen/pdf-rekap', 'AsesmenController::pdfRekap', ['filter' => 'auth']);

// Diagnosa Routes
$routes->get('/diagnosa', 'DiagnosaController::index', ['filter' => 'auth']);
$routes->post('/diagnosa/datatable', 'DiagnosaController::datatable', ['filter' => 'auth']);
$routes->get('/diagnosa/get/(:num)', 'DiagnosaController::get/$1', ['filter' => 'auth']);
$routes->get('/diagnosa/get-asesmen-list', 'DiagnosaController::getAsesmenList', ['filter' => 'auth']);
$routes->post('/diagnosa/save', 'DiagnosaController::save', ['filter' => 'auth']);
$routes->post('/diagnosa/delete/(:num)', 'DiagnosaController::delete/$1', ['filter' => 'auth']);
$routes->get('/diagnosa/pdf/(:num)', 'DiagnosaController::pdf/$1', ['filter' => 'auth']);
$routes->get('/diagnosa/pdf-rekap', 'DiagnosaController::pdfRekap', ['filter' => 'auth']);
$routes->get('/diagnosa/create', 'DiagnosaController::create', ['filter' => 'auth']);
$routes->post('/diagnosa/store', 'DiagnosaController::store', ['filter' => 'auth']);
$routes->get('/diagnosa/edit/(:num)', 'DiagnosaController::edit/$1', ['filter' => 'auth']);
$routes->post('/diagnosa/update/(:num)', 'DiagnosaController::update/$1', ['filter' => 'auth']);
