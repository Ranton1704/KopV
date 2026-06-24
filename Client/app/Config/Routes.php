<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');
$routes->get('/paiement', 'PaiementController::index');
$routes->post('/paiement/add', 'PaiementController::insertPaiement');