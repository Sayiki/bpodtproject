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
$routes->get('hash', 'Auth::updateAdminPassword');

$routes->get('form_data', 'WisataController::index');
$routes->get('tampil_data', 'WisataController::index2');
$routes->post('tambah_data', 'WisataController::tambahData');

$routes->get('detail/(:segment)', 'WisataController::detail/$1');
$routes->get('wisata', 'WisataController::index');
$routes->get('wisata/edit/(:num)', 'WisataController::edit/$1');
$routes->post('wisata/update/(:num)', 'WisataController::update/$1');
$routes->post('wisata/delete/(:num)', 'WisataController::delete/$1');
$routes->post('wisata/delete_multiple', 'WisataController::delete_multiple');

$routes->group('api', function ($routes) {
    $routes->resource('gallery', ['controller' => 'GalleryController']);
});

$routes->get('gallery', 'GalleryController::index');
$routes->post('gallery/create', 'GalleryController::create');
$routes->delete('gallery/delete/(:num)', 'GalleryController::delete/$1');
$routes->get('gallery/edit/(:num)', 'GalleryController::edit/$1');
$routes->post('gallery/update/(:num)', 'GalleryController::update/$1');
$routes->post('gallery/save-order', 'GalleryController::saveOrder');
