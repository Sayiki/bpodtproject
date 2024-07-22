<?php

use CodeIgniter\Router\RouteCollection;


/**
 * @var RouteCollection $routes
 */ 
$routes->get('/', 'Home::index');

$routes->get('login', 'Auth::login');
$routes->post('validate_login', 'Auth::validateLogin');
$routes->get('dashboard', 'Auth::dashboard');
$routes->get('logout', 'Auth::logout');
$routes->get('check_password_hash', 'Auth::checkPasswordHash');
$routes->get('test_password_hash', 'Auth::testPasswordHash');

$routes->get('tambah_data', 'WisataController::index');
$routes->get('tampil_data', 'WisataController::index2');

$routes->get('/wisata', 'WisataController::index');

