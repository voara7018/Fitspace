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
$routes->post('admin/confirmer/(:num)', 'Admin::confirmerReservation/$1');
$routes->post('admin/refuser/(:num)',   'Admin::refuserReservation/$1');

// Client routes
$routes->group('', ['filter' => 'auth'], function($routes) {
    $routes->get('/creneaux', 'Creneau::showCreneaux');
    $routes->get('/logout', 'User::logout');
    $routes->get('creneaux-disponibles', 'Creneau::getCreneauDispo');
    $routes->get('/creneaux-disponibles', 'Creneau::getCreneauDispo');
    $routes->get('/dashboard', 'User::showDashboard');
    $routes->get('/mes-reservations', 'Reservation::showMesReservations');

    $routes->get('reserver/(:num)', 'Reservation::showReserver/$1');
    $routes->get('annuler-reservation/(:num)', 'Reservation::annulerReservation/$1');

    
});

// Admin routes
$routes->group('admin', ['filter' => 'auth'], function($routes) {
    $routes->get('', 'Admin::showAdmin');
    $routes->get('ajouter-creneau', 'Admin::showAjouterCreneau');
    $routes->post('ajouter-creneau', 'Admin::ajouterCreneau');
    $routes->get('chart', 'Admin::showChart');
});

