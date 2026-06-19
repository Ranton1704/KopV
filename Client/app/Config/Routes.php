<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');


$routes->group('Voyage', function($routes) {
    // Étape 1 : Formulaire de recherche (Affichage simple)
    $routes->get('search', 'VoyageController::searchForm');

    // Étape 2 : Résultats de recherche (Accessible en GET suite à la soumission du formulaire)
    $routes->get('results', 'VoyageController::searchResults');

    // Étape 3 : Plan des sièges (Accessible en GET ou POST selon votre implémentation)
    $routes->get('seat-map', 'VoyageController::seatMap');
    $routes->post('seat-map', 'VoyageController::seatMap');

    // Étape 4 : Informations passagers (Reçoit les sièges choisis en POST)
    $routes->post('passenger-info', 'VoyageController::passengerInfo');

    // Étape 5 : Soumission finale des passagers avant envoi vers Spring Boot / Paiement
    $routes->post('submit-passengers', 'VoyageController::submitPassengers');
});