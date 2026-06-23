<?php

namespace App\Services;

use CodeIgniter\HTTP\CURLRequest;

class ApiService
{
    protected $client;
    protected $baseUrl;

    public function __construct()
    {
        $this->client = \Config\Services::curlrequest();
        // URL de base de l'API Spring Boot - à configurer selon votre environnement
        $this->baseUrl = getenv('API_BASE_URL') ?: 'http://localhost:8080/api';
    }

    /**
     * Récupérer la liste des gares
     */
    public function getGares()
    {
        // Pour le développement, utiliser les données mock par défaut
        // Commentez cette ligne pour utiliser l'API réelle
        return $this->getGaresMock();

        try {
            $response = $this->client->get($this->baseUrl . '/gares', [
                'headers' => [
                    'Accept' => 'application/json',
                    'Content-Type' => 'application/json'
                ],
                'timeout' => 10
            ]);

            if ($response->getStatusCode() === 200) {
                return json_decode($response->getBody(), true);
            }

            // En cas d'erreur, retourner des données de test pour le développement
            return $this->getGaresMock();
        } catch (\Exception $e) {
            log_message('error', 'API Error - getGares: ' . $e->getMessage());
            // Retourner des données de test pour le développement
            return $this->getGaresMock();
        }
    }

    /**
     * Rechercher des voyages disponibles
     */
    public function searchVoyages($departure, $arrival, $travelDate, $passengers)
    {
        // Pour le développement, utiliser les données mock par défaut
        // Commentez cette ligne pour utiliser l'API réelle
        return $this->searchVoyagesMock($departure, $arrival);

        try {
            $response = $this->client->get($this->baseUrl . '/voyages/search', [
                'query' => [
                    'departure' => $departure,
                    'arrival' => $arrival,
                    'date' => $travelDate,
                    'passengers' => $passengers
                ],
                'headers' => [
                    'Accept' => 'application/json',
                    'Content-Type' => 'application/json'
                ],
                'timeout' => 15
            ]);

            if ($response->getStatusCode() === 200) {
                return json_decode($response->getBody(), true);
            }

            // En cas d'erreur, retourner des données de test
            return $this->searchVoyagesMock($departure, $arrival);
        } catch (\Exception $e) {
            log_message('error', 'API Error - searchVoyages: ' . $e->getMessage());
            // Retourner des données de test pour le développement
            return $this->searchVoyagesMock($departure, $arrival);
        }
    }

    /**
     * Récupérer les détails d'un voyage
     */
    public function getVoyageDetails($tripId)
    {
        // Pour le développement, utiliser les données mock par défaut
        // Commentez cette ligne pour utiliser l'API réelle
        return $this->getVoyageDetailsMock($tripId);

        try {
            $response = $this->client->get($this->baseUrl . '/voyages/' . $tripId, [
                'headers' => [
                    'Accept' => 'application/json',
                    'Content-Type' => 'application/json'
                ],
                'timeout' => 10
            ]);

            if ($response->getStatusCode() === 200) {
                return json_decode($response->getBody(), true);
            }

            return $this->getVoyageDetailsMock($tripId);
        } catch (\Exception $e) {
            log_message('error', 'API Error - getVoyageDetails: ' . $e->getMessage());
            return $this->getVoyageDetailsMock($tripId);
        }
    }

    /**
     * Récupérer les places disponibles pour un voyage
     */
    public function getPlacesDisponibles($tripId)
    {
        // Pour le développement, utiliser les données mock par défaut
        // Commentez cette ligne pour utiliser l'API réelle
        return $this->getPlacesDisponiblesMock();

        try {
            $response = $this->client->get($this->baseUrl . '/voyages/' . $tripId . '/places', [
                'headers' => [
                    'Accept' => 'application/json',
                    'Content-Type' => 'application/json'
                ],
                'timeout' => 10
            ]);

            if ($response->getStatusCode() === 200) {
                return json_decode($response->getBody(), true);
            }

            return $this->getPlacesDisponiblesMock();
        } catch (\Exception $e) {
            log_message('error', 'API Error - getPlacesDisponibles: ' . $e->getMessage());
            return $this->getPlacesDisponiblesMock();
        }
    }

    /**
     * Verrouiller un siège temporairement
     */
    public function lockSeat($tripId, $seatId)
    {
        try {
            $response = $this->client->post($this->baseUrl . '/voyages/' . $tripId . '/places/' . $seatId . '/lock', [
                'headers' => [
                    'Accept' => 'application/json',
                    'Content-Type' => 'application/json'
                ],
                'json' => [
                    'duration' => 600 // 10 minutes en secondes
                ],
                'timeout' => 10
            ]);

            if ($response->getStatusCode() === 200) {
                return json_decode($response->getBody(), true);
            }

            return ['success' => false, 'message' => 'Erreur lors du verrouillage du siège'];
        } catch (\Exception $e) {
            log_message('error', 'API Error - lockSeat: ' . $e->getMessage());
            return ['success' => false, 'message' => 'Erreur de connexion au serveur'];
        }
    }

    /**
     * Déverrouiller un siège
     */
    public function unlockSeat($tripId, $seatId)
    {
        try {
            $response = $this->client->post($this->baseUrl . '/voyages/' . $tripId . '/places/' . $seatId . '/unlock', [
                'headers' => [
                    'Accept' => 'application/json',
                    'Content-Type' => 'application/json'
                ],
                'timeout' => 10
            ]);

            if ($response->getStatusCode() === 200) {
                return json_decode($response->getBody(), true);
            }

            return ['success' => false, 'message' => 'Erreur lors du déverrouillage du siège'];
        } catch (\Exception $e) {
            log_message('error', 'API Error - unlockSeat: ' . $e->getMessage());
            return ['success' => false, 'message' => 'Erreur de connexion au serveur'];
        }
    }

    /**
     * Créer une réservation
     */
    public function createReservation($reservationData)
    {
        try {
            $response = $this->client->post($this->baseUrl . '/reservations', [
                'headers' => [
                    'Accept' => 'application/json',
                    'Content-Type' => 'application/json'
                ],
                'json' => $reservationData,
                'timeout' => 15
            ]);

            if ($response->getStatusCode() === 201) {
                return json_decode($response->getBody(), true);
            }

            return ['success' => false, 'message' => 'Erreur lors de la création de la réservation'];
        } catch (\Exception $e) {
            log_message('error', 'API Error - createReservation: ' . $e->getMessage());
            return ['success' => false, 'message' => 'Erreur de connexion au serveur'];
        }
    }

    // ========== METHODES MOCK (Données de test pour le développement) ==========

    private function getGaresMock()
    {
        return [
            ['id' => 1, 'nom' => 'Gare d\'Antananarivo', 'ville' => 'Antananarivo'],
            ['id' => 2, 'nom' => 'Gare d\'Antsirabe', 'ville' => 'Antsirabe'],
            ['id' => 3, 'nom' => 'Gare de Toamasina', 'ville' => 'Toamasina'],
            ['id' => 4, 'nom' => 'Gare de Fianarantsoa', 'ville' => 'Fianarantsoa'],
            ['id' => 5, 'nom' => 'Gare de Mahajanga', 'ville' => 'Mahajanga']
        ];
    }

    private function searchVoyagesMock($departure, $arrival)
    {
        return [
            [
                'id' => 123,
                'cooperative' => 'Cotisse Transport',
                'vehicule' => 'Mercedes Sprinter Climatisé',
                'categorie' => 'VIP',
                'heure_depart' => '06:00',
                'heure_arrivee' => '11:30',
                'prix' => 35000,
                'places_restantes' => 8,
                'escales' => 'Moramanga (Arrêt repas de 20 min)',
                'bagages' => 'Soute fermée sécurisée. Maximum 20kg par personne.',
                'annulation' => 'Annulation gratuite jusqu\'à 24h avant le départ.'
            ],
            [
                'id' => 124,
                'cooperative' => 'Transport Mada',
                'vehicule' => 'Toyota Coaster',
                'categorie' => 'Standard',
                'heure_depart' => '08:30',
                'heure_arrivee' => '14:00',
                'prix' => 25000,
                'places_restantes' => 15,
                'escales' => 'Ambatolampy (Pause café)',
                'bagages' => 'Soute ouverte. Maximum 15kg par personne.',
                'annulation' => 'Annulation gratuite jusqu\'à 48h avant le départ.'
            ]
        ];
    }

    private function getVoyageDetailsMock($tripId)
    {
        return [
            'id' => $tripId,
            'cooperative' => 'Cotisse Transport',
            'vehicule' => 'Mercedes Sprinter Climatisé - Prises USB fonctionnelles',
            'categorie' => 'VIP',
            'heure_depart' => '06:00',
            'heure_arrivee' => '11:30',
            'duree' => '5h30',
            'prix' => 35000,
            'places_total' => 18,
            'escales' => 'Moramanga (Arrêt repas de 20 min)',
            'bagages' => 'Soute fermée sécurisée. Maximum 20kg par personne.',
            'annulation' => 'Annulation gratuite jusqu\'à 24h avant le départ.'
        ];
    }

    private function getPlacesDisponiblesMock()
    {
        return [
            ['id' => 1, 'numero' => '1', 'statut' => 'libre'],
            ['id' => 2, 'numero' => '2', 'statut' => 'libre'],
            ['id' => 3, 'numero' => '3', 'statut' => 'occupe'],
            ['id' => 4, 'numero' => '4', 'statut' => 'libre'],
            ['id' => 5, 'numero' => '5', 'statut' => 'libre'],
            ['id' => 6, 'numero' => '6', 'statut' => 'libre'],
            ['id' => 7, 'numero' => '7', 'statut' => 'libre'],
            ['id' => 8, 'numero' => '8', 'statut' => 'libre']
        ];
    }
}
