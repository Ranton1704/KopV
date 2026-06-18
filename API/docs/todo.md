# Module 1: Réservation
## A. Entités
- **CategorieVehicule**: id, libelle
- **Vehicule**: id, immatriculation, modele, *categorie*, nbPlaces
- **Place**: id, *vehicule*, numero

 
- **Gare**: id, nom, ville, position
- **Trajet**: id, *gareDepart*, *gareArrivee*, distance
- **TarifVoyage**: id, *categorie*, prix, dateModification
- **Voyage**: id, *trajet*, *vehicule*, *chauffeur*, dateheureDepart, dureeEstimee, tarif
- **StatutVoyage**: id, libelle
- **VoyageStatut**: id, *voyage*, *statut*, dateModification

 
- **Client**: id, nom, telephone

 
- **ReservationMere**: id, libelle, *voyage*, *client*, dateReservation, *statutPaiement*
- **ReservationFille**: id, *reservationMere*, *place*
- **StatutReservation**: id, libelle
- **ReservationStatut**: id, *reservation*, *statut*, dateModification
- **Annulation**: id, *reservation*, dateAnnulation, fraisAnnulation, motif

 
- **StatutPaiement**: id, libelle
- **ModePaiement**: id, libelle
- **Paiement**: id, *reservation*, dateAnnulation, fraisAnnulation, motif

## B. Desktop
### 1. Page de liste des réservations
#### a. Liste des trajets
- **Route**: GET /trajet/list
- **Output**:
```json
{
  "trajets": [
    {
      "id_trajet": 1,
      "libelle_trajet": "Tana - Tamatave"
    },
    // ...
  ]
}
```

#### b. Liste multicritère paginée
- **Route**: GET /reservation/list
- **Input**:
  - date
  - id_trajet
  - id_billet
  - numero_page
- **Output**:
```json
{
  "reservations": [
    {
      "id": 1,
      "code_billet": "BIL-2026-0001",
      "nom_client": "Rakoto",
      "numero_place": 1,
      "heure": "10:30",
      "montant": 50000,
      "statut_voyage": "confirmé"
    },
    // ...
  ],
  "nb_pages_total": 5,
}
```

#### c. Annuler une réservation
- **Route**: POST /reservation/annuler
- **Input**:
```json
{
  "id_reservation": 1,
  "frais_annulation": 10000,
  "motif": "Imprévu",
}
```
- **Traitement**:
  - insert into ReservationStatut (statut = `"annulée"`)
  - insert into Annulation

### 2. Page d’ajout d’une nouvelle réservation
#### a. Liste des voyages
- **Route**: GET /voyage/list
- **Input**:
  - date
- **Output**:
```json
{
  "voyages": [
    {
      "id": 1,
      "date_depart": "2026-06-18",
      "heure_depart": "08:00",
      "gare_depart": "Antananarivo",
      "gare_arrivee": "Toamasina",
      "duree": 360,
      "distance": 350,
      "immatriculation_vehicule": "1234 TBA",
      "modele_vehicule": "Mercedes Sprinter",
      "categorie_vehicule": "VIP",
      "tarif": 60000,
      "nb_places_disponibles": 10,
      "nb_places_restantes": 5,
      "nb_places_totales": 15
    },
    // ...
  ]
}
```

#### b. Liste des modes de paiements
- **Route**: GET /mode-paiement/list
- **Output**:
```json
{
  "modes_paiement": [
    {
      "id": 1,
      "libelle": "En espèce"
    },
    // ...
  ]
}
```

#### c. Informations d’un voyage
- **Route**: GET /voyage/*{id}*
- **Output**:
```json
{
  "id": 1,
  "date_depart": "2026-06-18",
  "heure_depart": "08:00",
  "gare_depart": "Antananarivo",
  "gare_arrivee": "Toamasina",
  "duree": 360,
  "distance": 350,
  "immatriculation_vehicule": "1234 TBA",
  "modele_vehicule": "Mercedes Sprinter",
  "categorie_vehicule": "VIP",
  "tarif": 60000,
  "nb_places_disponibles": 10,
  "nb_places_restantes": 5,
  "nb_places_totales": 15
}
```

#### d. Places d’un véhicule
- **Route**: GET /vehicule/*{id}*/place/list
- **Output**:
```json
{
  "places": [
    {
      "id": 1,
      "numero": "A1",
      "occupee": false
    }
  ]
}
```

#### c. Créer une nouvelle réservation
- **Route**: POST /reservation/new
- **Input**:
```json
{
  "libelle": "Réservation du 19/06/2026 pour 4 personnes",
  "id_voyage": 1,
  "nom_client": "Rakoto",
  "telephone_client": "0341234567",
  "montant_paye": 100000,
  "id_mode_paiement": 1,
  "reference_paiement": null,
  "id_places": [3, 4, 5, 6]
}
```
- **Traitement**:
  - insert into Client
  - insert into ReservationMere
  - insert into ReservationFille
  - insert into ReservationStatut (statut = `"confirmée"`)
  - insert into Paiement
