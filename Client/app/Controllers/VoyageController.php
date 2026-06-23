<?php

namespace App\Controllers;

use App\Services\ApiService;
use App\Models\VoyageModel;
use App\Models\GareModel;

class VoyageController extends BaseController
{
    protected $apiService;
    protected $voyageModel;
    protected $gareModel;

    public function __construct()
    {
        $this->apiService = new ApiService();
        $this->voyageModel = new VoyageModel();
        $this->gareModel = new GareModel();
    }

    /**
     * Étape 1 : Formulaire de recherche de trajet
     */
    public function searchForm()
    {
        // Récupérer la liste des gares depuis l'API
        $gares = $this->apiService->getGares();
        
        $data = [
            'gares' => $gares,
            'title' => 'Rechercher un trajet - KOP-V'
        ];

        return view('recherche_voyage/search_form', $data);
    }

    /**
     * Étape 2 : Résultats de recherche
     */
    public function searchResults()
    {
        $departure = $this->request->getGet('departure');
        $arrival = $this->request->getGet('arrival');
        $travelDate = $this->request->getGet('travel_date');
        $passengers = $this->request->getGet('passengers');
        
        // Valeur par défaut pour passengers
        if (empty($passengers) || !is_numeric($passengers)) {
            $passengers = 1;
        }

        // Validation des paramètres
        if (empty($departure) || empty($arrival) || empty($travelDate)) {
            return redirect()->to('/Voyage/search')->with('error', 'Veuillez remplir tous les champs de recherche');
        }

        // Appel à l'API pour rechercher les voyages
        $voyages = $this->apiService->searchVoyages($departure, $arrival, $travelDate, $passengers);

        $data = [
            'departure' => $departure,
            'arrival' => $arrival,
            'travel_date' => $travelDate,
            'passengers' => $passengers,
            'voyages' => $voyages,
            'title' => 'Résultats de recherche - KOP-V'
        ];

        return view('recherche_voyage/search_results', $data);
    }

    /**
     * Étape 3 : Plan des sièges (Seat Map)
     */
    public function seatMap()
    {
        $tripId = $this->request->getGet('trip_id') ?? $this->request->getPost('trip_id');
        $passengers = $this->request->getGet('passengers') ?? $this->request->getPost('passengers');
        
        // Valeur par défaut pour passengers
        if (empty($passengers) || !is_numeric($passengers)) {
            $passengers = 1;
        }

        if (empty($tripId)) {
            return redirect()->to('/Voyage/search')->with('error', 'Veuillez sélectionner un voyage');
        }

        // Récupérer les détails du voyage et les places disponibles
        $voyage = $this->apiService->getVoyageDetails($tripId);
        $places = $this->apiService->getPlacesDisponibles($tripId);

        $data = [
            'trip_id' => $tripId,
            'passengers' => $passengers,
            'voyage' => $voyage,
            'places' => $places,
            'title' => 'Sélection des places - KOP-V'
        ];

        return view('recherche_voyage/seat_map', $data);
    }

    /**
     * Étape 4 : Informations des passagers
     */
    public function passengerInfo()
    {
        $tripId = $this->request->getPost('trip_id');
        $chosenSeats = $this->request->getPost('chosen_seats');

        if (empty($tripId) || empty($chosenSeats)) {
            return redirect()->to('/Voyage/search')->with('error', 'Veuillez sélectionner des places');
        }

        // Récupérer les détails du voyage
        $voyage = $this->apiService->getVoyageDetails($tripId);

        // Parser les sièges choisis
        $seatsArray = explode(',', $chosenSeats);

        $data = [
            'trip_id' => $tripId,
            'chosen_seats' => $chosenSeats,
            'seats_array' => $seatsArray,
            'voyage' => $voyage,
            'title' => 'Informations des passagers - KOP-V'
        ];

        return view('recherche_voyage/passenger_info', $data);
    }

    /**
     * Étape 5 : Soumission finale des passagers
     */
    public function submitPassengers()
    {
        $tripId = $this->request->getPost('trip_id');
        $chosenSeats = $this->request->getPost('chosen_seats');
        $passengers = $this->request->getPost('passengers');

        // Validation des données
        if (empty($tripId) || empty($chosenSeats) || empty($passengers)) {
            return redirect()->back()->with('error', 'Veuillez remplir tous les champs obligatoires');
        }

        // Préparer les données pour l'API
        $reservationData = [
            'voyage_id' => $tripId,
            'places' => explode(',', $chosenSeats),
            'passagers' => $passengers
        ];

        // Appel à l'API pour créer la réservation
        $response = $this->apiService->createReservation($reservationData);

        if ($response['success']) {
            // Rediriger vers la page de paiement (Développeur C)
            return redirect()->to('/payment/' . $response['reservation_id']);
        } else {
            return redirect()->back()->with('error', 'Erreur lors de la création de la réservation: ' . $response['message']);
        }
    }

    /**
     * API endpoint pour verrouiller un siège (AJAX)
     */
    public function lockSeat()
    {
        if (!$this->request->isAJAX()) {
            return $this->response->setStatusCode(403)->setJSON(['success' => false, 'message' => 'Accès non autorisé']);
        }

        $tripId = $this->request->getPost('trip_id');
        $seatId = $this->request->getPost('seat_id');

        $response = $this->apiService->lockSeat($tripId, $seatId);

        return $this->response->setJSON($response);
    }

    /**
     * API endpoint pour déverrouiller un siège (AJAX)
     */
    public function unlockSeat()
    {
        if (!$this->request->isAJAX()) {
            return $this->response->setStatusCode(403)->setJSON(['success' => false, 'message' => 'Accès non autorisé']);
        }

        $tripId = $this->request->getPost('trip_id');
        $seatId = $this->request->getPost('seat_id');

        $response = $this->apiService->unlockSeat($tripId, $seatId);

        return $this->response->setJSON($response);
    }
}
