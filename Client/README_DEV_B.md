# Développeur B : Tunnel de Recherche & Réservation

## 📋 Vue d'ensemble

Ce module gère le cœur métier du parcours client : la recherche de trajets, l'affichage des voyages disponibles selon les classes de confort et l'expérience interactive de sélection des places.

## 🏗️ Structure créée

### Controllers
- **VoyageController.php** : Controller principal gérant toutes les étapes du tunnel de réservation
  - `searchForm()` : Formulaire de recherche de trajet
  - `searchResults()` : Affichage des résultats de recherche
  - `seatMap()` : Plan interactif du véhicule (sélection des places)
  - `passengerInfo()` : Formulaire d'informations des passagers
  - `submitPassengers()` : Soumission finale avant paiement
  - `lockSeat()` : API endpoint AJAX pour verrouiller un siège
  - `unlockSeat()` : API endpoint AJAX pour déverrouiller un siège

### Services
- **ApiService.php** : Service de communication avec le backend Spring Boot
  - `getGares()` : Récupérer la liste des gares
  - `searchVoyages()` : Rechercher des voyages disponibles
  - `getVoyageDetails()` : Récupérer les détails d'un voyage
  - `getPlacesDisponibles()` : Récupérer les places disponibles pour un voyage
  - `lockSeat()` : Verrouiller temporairement un siège
  - `unlockSeat()` : Déverrouiller un siège
  - `createReservation()` : Créer une réservation
  - **Note** : Chaque méthode inclut des données mock pour le développement en cas d'indisponibilité de l'API

### Models
- **VoyageModel.php** : Modèle pour les données de voyages
- **GareModel.php** : Modèle pour les données de gares

### Views
- **layout.php** : Layout principal avec Bootstrap 5
- **recherche_voyage/search_form.php** : Formulaire de recherche
- **recherche_voyage/search_results.php** : Résultats de recherche avec filtres
- **recherche_voyage/seat_map.php** : Plan interactif des sièges avec minuterie
- **recherche_voyage/passenger_info.php** : Formulaire des informations passagers

## 🔧 Configuration

### Fichier .env
Le fichier `.env` contient la configuration de l'URL de l'API Spring Boot :

```env
API_BASE_URL = http://localhost:8080/api
```

**Important** : Modifiez cette URL selon l'adresse de votre backend Spring Boot.

### Routes
Les routes sont configurées dans `app/Config/Routes.php` :

```php
$routes->group('Voyage', function($routes) {
    $routes->get('search', 'VoyageController::searchForm');
    $routes->get('results', 'VoyageController::searchResults');
    $routes->get('seat-map', 'VoyageController::seatMap');
    $routes->post('seat-map', 'VoyageController::seatMap');
    $routes->post('passenger-info', 'VoyageController::passengerInfo');
    $routes->post('submit-passengers', 'VoyageController::submitPassengers');
    $routes->post('lock-seat', 'VoyageController::lockSeat');
    $routes->post('unlock-seat', 'VoyageController::unlockSeat');
});
```

## 🚀 Fonctionnalités implémentées

### 1. Recherche de voyage
- ✅ Sélection de la ville de départ (avec données de l'API)
- ✅ Sélection de la ville d'arrivée
- ✅ Sélecteur de date (datepicker)
- ✅ Compteur du nombre de passagers
- ✅ Bouton d'inversion rapide départ/arrivée

### 2. Liste des résultats de recherche
- ✅ Cartes de trajets détaillées : compagnie, heure de départ, heure d'arrivée estimée, prix, places restantes
- ✅ Modal de détails du voyage (véhicule, escales, bagages, annulation)
- ✅ Gestion du cas "aucun résultat"
- ⏳ Options de tri (à implémenter côté frontend)
- ⏳ Filtres de recherche avancés (structure prête, logique à compléter)

### 3. Plan interactif du véhicule (Seat Map)
- ✅ Représentation graphique des sièges (États : libre, occupé, sélectionné)
- ✅ Légende des couleurs associée
- ✅ Logique de sélection multiple indexée sur le nombre de passagers
- ✅ Appels AJAX pour verrouillage/déverrouillage des sièges
- ✅ Minuteur de 10 minutes pour libérer les places
- ✅ Intégration avec l'API pour récupérer les places disponibles

### 4. Informations des passagers
- ✅ Formulaire dynamique basé sur le nombre de places sélectionnées
- ✅ Saisie des champs obligatoires (Nom complet, téléphone, CIN)
- ✅ Validation stricte des champs (CIN : 12 chiffres)
- ✅ Option "Remplir automatiquement avec mes informations de profil"
- ✅ Identification du passager principal

## 🔌 Intégration API Spring Boot

L'application est configurée pour communiquer avec un backend Spring Boot. Les endpoints attendus sont :

### Endpoints API
- `GET /api/gares` : Liste des gares
- `GET /api/voyages/search` : Recherche de voyages
  - Paramètres : `departure`, `arrival`, `date`, `passengers`
- `GET /api/voyages/{id}` : Détails d'un voyage
- `GET /api/voyages/{id}/places` : Places disponibles pour un voyage
- `POST /api/voyages/{id}/places/{seatId}/lock` : Verrouiller un siège
- `POST /api/voyages/{id}/places/{seatId}/unlock` : Déverrouiller un siège
- `POST /api/reservations` : Créer une réservation

### Données mock
En attendant que l'équipe backend déploie l'API Spring Boot, des données mock sont incluses dans `ApiService.php`. L'application utilisera automatiquement ces données si l'API n'est pas disponible.

## 📝 Utilisation

### Démarrage du serveur de développement

```bash
cd Client
php spark serve
```

L'application sera accessible sur `http://localhost:8080`

### Flux utilisateur

1. **Recherche** : `/Voyage/search`
   - L'utilisateur sélectionne les villes, la date et le nombre de passagers
   - Soumet le formulaire pour voir les résultats

2. **Résultats** : `/Voyage/results`
   - L'utilisateur voit la liste des voyages disponibles
   - Peut filtrer par classe de confort et tranche horaire
   - Clique sur "Détails" pour voir plus d'informations
   - Clique sur "Choisir" pour sélectionner un voyage

3. **Sélection des places** : `/Voyage/seat-map`
   - L'utilisateur voit le plan interactif du véhicule
   - Sélectionne les places selon le nombre de passagers
   - Les places sont verrouillées temporairement via AJAX
   - Un minuterie de 10 minutes s'active
   - Confirme les places pour passer à l'étape suivante

4. **Informations passagers** : `/Voyage/passenger-info`
   - L'utilisateur remplit les informations pour chaque passager
   - Le premier passager est considéré comme le responsable de la réservation
   - Validation stricte des champs (CIN : 12 chiffres)
   - Soumet pour passer au paiement (géré par le Développeur C)

## ⚠️ Points d'attention

### Verrouillage des sièges
Le système de verrouillage des sièges est critique pour éviter le surbooking. L'implémentation actuelle :
- Envoie des requêtes AJAX lors de la sélection/désélection
- Utilise un minuterie de 10 minutes côté client
- **À compléter** : Le backend doit implémenter la logique de verrouillage avec expiration automatique

### Validation des données
- Le CIN doit comporter exactement 12 chiffres (réglementation malgache)
- Le numéro de téléphone doit comporter 9 chiffres (après l'indicatif +261)
- Ces validations sont effectuées côté client et devraient être également effectuées côté serveur

### Gestion des erreurs API
L'application inclut une gestion des erreurs basique avec des logs. Pour la production :
- Améliorer la gestion des erreurs
- Ajouter des messages utilisateur plus explicites
- Implémenter un système de retry pour les appels API

## 🔄 Prochaines étapes

1. **Intégration backend** : Coordonner avec l'équipe Spring Boot pour :
   - Définir le format exact des réponses API
   - Implémenter le verrouillage des sièges côté serveur
   - Tester l'intégration complète

2. **Fonctionnalités avancées** :
   - Implémenter les filtres de recherche avancés
   - Ajouter les options de tri
   - Gérer le cas des véhicules sans sièges numérotés

3. **Tests** :
   - Écrire des tests unitaires pour le controller
   - Tester le flux complet de bout en bout
   - Tester les scénarios d'erreur

4. **Optimisation** :
   - Ajouter du cache pour les données statiques (gares)
   - Optimiser les appels API
   - Améliorer l'expérience utilisateur (loading states, etc.)

## 📞 Support

Pour toute question sur ce module, contactez le Développeur B ou référez-vous à la documentation du projet.
