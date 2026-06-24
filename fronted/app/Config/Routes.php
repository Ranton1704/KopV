<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/reservations/list', 'ReservationController::liste');
// Route demandée: /reservations/catalogue
$routes->match(['get', 'post'], '/reservations/catalogue', 'ReservationController::catalogue');
