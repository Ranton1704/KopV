# 🗺️ Répartition du TODO — Développement Parallèle (App Client KOP-V)


---

## 💻 Développeur A : Gestion des Utilisateurs & Composants Transverses
*Ce rôle est l'ancre du projet. Il se concentre sur l'accès à l'application, l'authentification, le profil utilisateur et l'infrastructure technique globale qui servira de socle aux deux autres développeurs.*

### 1. Authentification / Compte
- [ ] **Écran de connexion** (téléphone ou email + mot de passe)
- [ ] **Écran d'inscription**
  - [ ] Formulaire : nom, téléphone, email, mot de passe
  - [ ] Intégration de la vérification OTP par SMS *(Incontournable pour Madagascar, l'usage du numéro de téléphone étant prédominant)*
  - [ ] Validation optionnelle par email
- [ ] **Mot de passe oublié /**
  - [ ] Envoi du code de récupération par SMS ou email
  - [ ] Formulaire de saisie du nouveau mot de passe
- [ ] **Connexion invité** *(Optionnel : autoriser la réservation rapide avec uniquement un numéro de téléphone)*
- [ ] **Gestion de session** (Mise en place des tokens JWT et refresh tokens)
- [ ] **Écran Profil Utilisateur**
  - [ ] Modification des informations personnelles (nom, téléphone, email, photo)
  - [ ] Changement de mot de passe sécurisé
  - [ ] Action de déconnexion
  - [ ] Action de suppression définitive du compte *(Obligation légale sur les stores d'applications)*


## 💻 Développeur B : Tunnel de Recherche & Réservation
*Ce rôle gère le cœur métier du parcours client : la recherche de trajets, l'affichage des voyages disponibles selon les classes de confort et l'expérience interactive de sélection des places.*

### 2. Recherche de voyage
- [ ] **Formulaire de recherche de trajet**
  - [ ] Sélection de la ville de départ (select ou autocomplete, ex: Antananarivo)
  - [ ] Sélection de la ville d'arrivée (ex: Antsirabe, Toamasina)
  - [ ] Sélecteur de date (datepicker)
  - [ ] Compteur du nombre de passagers
  - [ ] Bouton d'inversion rapide départ/arrivée
- [ ] **Liste des résultats de recherche (Voyages disponibles)**
  - [ ] Cartes de trajets détaillées : compagnie, heure de départ, heure d'arrivée estimée, prix, places restantes
  - [ ] Options de tri (par prix, par heure, par durée)
  - [ ] Filtres de recherche avancés (par type de véhicule, tranche horaire, prix max, classe de confort : Standard, Confort, VIP)
  - [ ] Gestion du cas "aucun résultat" (Affichage d'un message clair et suggestions de dates proches)
- [ ] **Écran Détail d'un voyage**
  - [ ] Informations de la coopérative (nom, logo)
  - [ ] Type et état du véhicule (bus, minibus, taxi-brousse)
  - [ ] Affichage des points d'arrêt et escales intermédiaires
  - [ ] Affichage des politiques d'annulation et de la gestion prévisionnelle des bagages volumineux

### 3. Sélection des places & 4. Infos passagers
- [ ] **Plan interactif du véhicule (Seat Map)**
  - [ ] Représentation graphique et visuelle des sièges (États : libre, occupé, sélectionné en cours)
  - [ ] Légende des couleurs associée
  - [ ] Logique de sélection multiple indexée sur le nombre de passagers déclaré
  - [ ] *Connexion Backend critique :* Intégration du système de verrouillage/blocage temporaire du siège (expiration après 5 à 10 minutes pour éviter le surbooking et sécuriser la place face aux guichets physiques)
- [ ] **Gestion alternative des places** (Cas où les sièges ne sont pas numérotés : réservation simple par quantité de places)
- [ ] **Écran de récapitulatif des places** sélectionnées avant validation du profil passager
- [ ] **Formulaire d'informations des passagers**
  - [ ] Saisie des champs obligatoires (Nom complet, numéro de téléphone du passager principal)
  - [ ] Saisie du numéro de carte d'identité (CIN) si requis réglementairement pour les longs trajets nationaux
  - [ ] Option "Remplir automatiquement avec mes informations de profil" (pour le passager principal)
  - [ ] Validation stricte des champs du formulaire avant passage à l'étape suivante

---

## 💻 Développeur C : Paiement, Billetterie & Gestion des Réservations
*Ce rôle prend le relais dès que le panier est validé. Il est responsable de la gestion financière (Mobile Money), de la génération sécurisée des billets électroniques et du suivi de l'espace client après-vente.*

### 5. Récapitulatif & Paiement
- [ ] **Écran récapitulatif final de la commande**
  - [ ] Détails complets du voyage (trajet, date, heure, numéros de places, identité des passagers)
  - [ ] Décomposition transparente du prix (prix unitaire x passagers, taxes, frais de service éventuels, calcul du total)
  - [ ] Champ d'application pour code de réduction / code promo (optionnel)
- [ ] **Sélection du mode de paiement**
  - [ ] Intégration prioritaire du Mobile Money (Mvola, Orange Money, Airtel Money — incontournable pour le marché malgache)
  - [ ] Option de paiement par Carte Bancaire (pour la clientèle internationale ou bancarisée)
  - [ ] Option de paiement alternatif ("Payer plus tard" au guichet / réservation seule à l'embarquement si autorisé)
- [ ] **Intégration technique des API de paiement**
  - [ ] Gestion des redirections sécurisées ou formulaires de paiement intégrés
  - [ ] Traitement des callbacks et webhooks de confirmation transmis par le serveur de paiement
  - [ ] Gestion des échecs de transaction (bouton de réessai, messages d'erreurs explicites)
- [ ] **Écran de statut de paiement** (Succès, Échec, Transaction en attente de validation USSD/OTP)

### 6. Ticket / Confirmation & 8. Notifications
- [ ] **Génération du billet électronique (E-ticket)**
  - [ ] Génération d'un QR code unique ou code-barres exploitable par le scanner de l'agent au guichet de la gare privée
  - [ ] Attribution d'un numéro de réservation unique
  - [ ] Inclusion de toutes les données du trajet (places, passagers, dates, classe de confort)
- [ ] **Automatisation des envois**
  - [ ] Envoi d'un SMS de confirmation contenant le code unique ou un lien de téléchargement
  - [ ] Envoi d'un email de confirmation avec le billet PDF joint (si l'email a été renseigné)
- [ ] **Écran "Mon Billet" au sein de l'application**
  - [ ] Options de téléchargement en local et de partage du billet
  - [ ] Mise en place d'un système de cache local pour permettre un **affichage offline du QR Code** à la gare en cas de coupure réseau
- [ ] **Système de Notifications**
  - [ ] Envoi de notifications push (Rappels de départ 2h avant, alertes en cas de changement d'horaire, annulation d'un départ, confirmation de paiement reçu)
  - [ ] Module de Centre de notifications intégré à l'application

### 7. Gestion des réservations (Espace Client)
- [ ] **Écran d'historique des voyages**
  - [ ] Liste des voyages à venir (actifs) et des voyages passés (historique)
  - [ ] Affichage des statuts en temps réel (Confirmé, En cours, Annulé, Terminé)
- [ ] **Vue détaillée d'une réservation** passée ou future
- [ ] **Module d'annulation de réservation**
  - [ ] Application automatique des règles de calcul de remboursement (remboursement partiel ou total selon les délais de la politique de la coopérative)
  - [ ] Écran de confirmation avant validation définitive de l'annulation
- [ ] **Module de modification de billet** (Changement de date de départ ou de siège si autorisé par la compagnie)
- [ ] **Suivi des remboursements** (Visualisation du statut du remboursement, versement direct vers le compte Mobile Money d'origine ou transformation en crédit/avoir sur l'application)

---
