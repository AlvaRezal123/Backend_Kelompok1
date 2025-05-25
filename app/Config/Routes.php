<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');

// Routes untuk Authentication
$routes->group('auth', function($routes) {
    $routes->post('login', 'UserController::login');
    $routes->post('register', 'UserController::register');
});

// Routes untuk User Management
$routes->group('user', function($routes) {
    $routes->get('/', 'UserController::getAllUsers');
    $routes->put('update/(:segment)', 'UserController::updateUser/$1');
    $routes->delete('delete/(:segment)', 'UserController::deleteUser/$1');
});

// Routes untuk Mahasiswa API
$routes->group('mahasiswa', function($routes) {
    $routes->get('/', 'MahasiswaController::index');
    $routes->get('(:segment)', 'MahasiswaController::show/$1');
    $routes->post('/', 'MahasiswaController::store');
    $routes->put('update/(:segment)', 'MahasiswaController::update/$1');
    $routes->delete('delete/(:segment)', 'MahasiswaController::delete/$1');
});

// Routes untuk Pembimbing API
$routes->group('pembimbing', function($routes) {
    $routes->get('/', 'PembimbingController::index');
    $routes->get('(:segment)', 'PembimbingController::show/$1');
    $routes->post('/', 'PembimbingController::store');
    $routes->put('update/(:segment)', 'PembimbingController::update/$1');
    $routes->delete('delete/(:segment)', 'PembimbingController::delete/$1');
});

// Routes untuk Perusahaan API
$routes->group('perusahaan', function($routes) {
    $routes->get('/', 'PerusahaanController::index');
    $routes->get('(:segment)', 'PerusahaanController::show/$1');
    $routes->post('/', 'PerusahaanController::store');
    $routes->put('update/(:segment)', 'PerusahaanController::update/$1');
    $routes->delete('delete/(:segment)', 'PerusahaanController::delete/$1');
});

// Routes untuk Magang API
$routes->group('magang', function($routes) {
    $routes->get('/', 'MagangController::index');
    $routes->get('(:num)', 'MagangController::show/$1');
    $routes->post('/', 'MagangController::store');
    $routes->put('update/(:num)', 'MagangController::update/$1');
    $routes->delete('delete/(:num)', 'MagangController::delete/$1');
});