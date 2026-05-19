<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
// Public routes
$routes->get('/', 'User::showLogin');
$routes->get('/inscription', 'User::showInscription');
$routes->post('/inscription', 'User::insertUser');
$routes->post('/login', 'User::loginUser');

// Client protected routes
$routes->group('', ['filter' => 'auth'], function($routes) {
    $routes->get('/creneaux', 'Creneau::showCreneaux');
    $routes->get('/logout', 'User::logout');
});

// Admin protected routes
$routes->group('admin', ['filter' => 'auth'], function($routes) {
    $routes->get('', 'Admin::showAdmin');
});

