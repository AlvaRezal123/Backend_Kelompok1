<?php

use CodeIgniter\Router\RouteCollection;

use App\Controllers\MahasiswaController;
use App\Controllers\UserController;
use App\Controllers\PembimbingController;
use App\Controllers\PerusahaanController;
use App\Controllers\ViewController;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');
$routes->get('mahasiswa', 'MahasiswaController::index');

$routes->post('api/register', 'UserController::register');
$routes->post('api/login', 'UserController::login');
$routes->get('api/users', 'UserController::getAllUsers');  // Menampilkan semua user
$routes->delete('api/users/(:num)', 'UserController::deleteUser/$1'); // Hapus user berdasarkan ID
$routes->put('api/users/(:num)', 'UserController::updateUser/$1');




$routes->post('login', 'UserController::login');

$routes->post('mahasiswa', 'MahasiswaController::create');
$routes->put('mahasiswa/update/(:num)', 'MahasiswaController::update/$1');
$routes->post('mahasiswa/create', 'MahasiswaController::store');
$routes->delete('mahasiswa/delete/(:num)', 'MahasiswaController::delete/$1');


$routes->get('pembimbing', 'PembimbingController::index');
$routes->post('/pembimbing/create', 'PembimbingController::store');
$routes->put('/pembimbing/update/(:num)', 'PembimbingController::update/$1');
$routes->delete('/pembimbing/delete/(:num)', 'PembimbingController::delete/$1');

$routes->get('perusahaan', 'PerusahaanController::index');
$routes->post('perusahaan/create', 'PerusahaanController::create'); 
$routes->put('perusahaan/update/(:num)', 'PerusahaanController::update/$1');
$routes->delete('perusahaan/delete/(:num)', 'PerusahaanController::delete/$1'); 

$routes->get('magang', 'MagangController::index');
$routes->post('magang/create', 'MagangController::create'); 
$routes->put('/magang/update/(:segment)', 'MagangController::update/$1');
$routes->delete('/magang/delete/(:segment)', 'MagangController::delete/$1');

$routes->get('/magang/view', 'ViewController::index'); 
