<?php

namespace App\Models;

use CodeIgniter\Model;

class VoyageModel extends Model
{
    protected $table = 'voyages';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $returnType = 'array';
    protected $useSoftDeletes = false;
    protected $allowedFields = [
        'id_trajet',
        'id_vehicule',
        'id_chauffeur',
        'date_heure_depart',
        'duree_estimee_minutes',
        'tarif'
    ];

    protected $useTimestamps = false;
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';

    /**
     * Récupérer les voyages disponibles pour une recherche
     */
    public function searchVoyages($departure, $arrival, $date, $passengers = 1)
    {
        // Cette méthode sera utilisée si vous avez besoin d'une base de données locale
        // Sinon, tout passe par l'API Spring Boot
        $builder = $this->db->table('voyages v')
            ->select('v.*, t.id_gare_depart, t.id_gare_arrivee, 
                     gd.nom as gare_depart_nom, gd.ville as ville_depart,
                     ga.nom as gare_arrivee_nom, ga.ville as ville_arrivee,
                     veh.modele, veh.immatriculation, cat.libelle as categorie,
                     u.nom as chauffeur_nom, u.prenom as chauffeur_prenom')
            ->join('trajets t', 'v.id_trajet = t.id')
            ->join('gares gd', 't.id_gare_depart = gd.id')
            ->join('gares ga', 't.id_gare_arrivee = ga.id')
            ->join('vehicules veh', 'v.id_vehicule = veh.id')
            ->join('categorie_vehicule cat', 'veh.id_categorie = cat.id')
            ->join('utilisateurs u', 'v.id_chauffeur = u.id')
            ->where('gd.ville', $departure)
            ->where('ga.ville', $arrival)
            ->where('DATE(v.date_heure_depart)', $date)
            ->where('v.statut', 'plannifié');

        return $builder->get()->getResultArray();
    }

    /**
     * Récupérer les détails d'un voyage
     */
    public function getVoyageDetails($voyageId)
    {
        $builder = $this->db->table('voyages v')
            ->select('v.*, t.id_gare_depart, t.id_gare_arrivee, t.distance_km,
                     gd.nom as gare_depart_nom, gd.ville as ville_depart,
                     ga.nom as gare_arrivee_nom, ga.ville as ville_arrivee,
                     veh.modele, veh.immatriculation, veh.nombre_places,
                     cat.libelle as categorie,
                     u.nom as chauffeur_nom, u.prenom as chauffeur_prenom')
            ->join('trajets t', 'v.id_trajet = t.id')
            ->join('gares gd', 't.id_gare_depart = gd.id')
            ->join('gares ga', 't.id_gare_arrivee = ga.id')
            ->join('vehicules veh', 'v.id_vehicule = veh.id')
            ->join('categorie_vehicule cat', 'veh.id_categorie = cat.id')
            ->join('utilisateurs u', 'v.id_chauffeur = u.id')
            ->where('v.id', $voyageId);

        return $builder->get()->getRowArray();
    }

    /**
     * Récupérer les places disponibles pour un voyage
     */
    public function getAvailableSeats($voyageId)
    {
        $voyage = $this->getVoyageDetails($voyageId);
        $vehiculeId = $voyage['id_vehicule'];

        // Récupérer toutes les places du véhicule
        $allSeats = $this->db->table('places')
            ->where('id_vehicule', $vehiculeId)
            ->get()->getResultArray();

        // Récupérer les places déjà réservées pour ce voyage
        $reservedSeats = $this->db->table('reservations_fille rf')
            ->join('reservations_mere rm', 'rf.id_reservation_mere = rm.id')
            ->where('rm.id_voyage', $voyageId)
            ->where('rm.id_statut_paiement !=', 3) // 3 = annulé
            ->get()->getResultArray();

        $reservedSeatIds = array_column($reservedSeats, 'id_place');

        // Marquer les places comme libres ou occupées
        foreach ($allSeats as &$seat) {
            $seat['statut'] = in_array($seat['id'], $reservedSeatIds) ? 'occupe' : 'libre';
        }

        return $allSeats;
    }
}
