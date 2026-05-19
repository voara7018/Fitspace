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

// Client routes
$routes->group('', ['filter' => 'auth'], function($routes) {
    $routes->get('/creneaux', 'Creneau::showCreneaux');
    $routes->get('/logout', 'User::logout');
    $routes->get('creneaux-disponibles', 'Creneau::getCreneauDispo');
    
});

// Admin routes
$routes->group('admin', ['filter' => 'auth'], function($routes) {
    $routes->get('', 'Admin::showAdmin');
    $routes->get('ajouter-creneau', 'Admin::showAjouterCreneau');
});

