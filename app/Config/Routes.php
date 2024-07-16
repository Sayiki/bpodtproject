<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');
$routes->get('login', 'Auth::login');
$routes->get('dashboard', 'Auth::dashboard');
$routes->post('validate_login', 'Auth::validate_login');
$routes->get('tambah_data', 'DataWisata::index');
$routes->get('tampil_data', 'DataWisata::index2');
