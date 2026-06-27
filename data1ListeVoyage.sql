CREATE TABLE role (
    id      SERIAL PRIMARY KEY,
    libelle VARCHAR(50) NOT NULL
        CONSTRAINT chk_role_libelle
        CHECK (libelle IN ('admin', 'guichet', 'chauffeur', 'RH', 'RE'))
);


CREATE TABLE utilisateurs (
    id            SERIAL PRIMARY KEY,
    nom           VARCHAR(100) NOT NULL,
    prenom        VARCHAR(100) NOT NULL,
    id_role       INTEGER      NOT NULL REFERENCES role(id),
    email         VARCHAR(150) NOT NULL UNIQUE,
    mot_de_passe  VARCHAR(255) NOT NULL
);


CREATE TABLE categorie_vehicule (
    id   SERIAL PRIMARY KEY,
    libelle VARCHAR(50) NOT NULL
        CONSTRAINT chk_categorie_libelle
        CHECK (libelle IN ('VIP', 'Premium', 'Standard'))
);


CREATE TABLE vehicules (
    id              SERIAL PRIMARY KEY,
    immatriculation VARCHAR(20)  NOT NULL UNIQUE,
    modele          VARCHAR(100) NOT NULL,
    id_categorie    INTEGER      NOT NULL REFERENCES categorie_vehicule(id),
    nombre_places   SMALLINT     NOT NULL CHECK (nombre_places > 0)
);

CREATE TABLE places (
    id          SERIAL PRIMARY KEY,
    id_vehicule INTEGER     NOT NULL REFERENCES vehicules(id),
    numero      VARCHAR(10) NOT NULL,
    UNIQUE (id_vehicule, numero)
);


CREATE TABLE gares (
    id       SERIAL PRIMARY KEY,
    nom      VARCHAR(150) NOT NULL,
    ville    VARCHAR(100) NOT NULL
);


CREATE TABLE trajets (
    id              SERIAL PRIMARY KEY,
    id_gare_depart  INTEGER        NOT NULL REFERENCES gares(id),
    id_gare_arrivee INTEGER        NOT NULL REFERENCES gares(id),
    distance_km     NUMERIC(10, 2) NOT NULL CHECK (distance_km > 0),
    CONSTRAINT chk_trajet_gares_differentes
        CHECK (id_gare_depart <> id_gare_arrivee)
);


CREATE TABLE voyages (
    id                      SERIAL          PRIMARY KEY,
    id_trajet               INTEGER         NOT NULL REFERENCES trajets(id),
    id_vehicule             INTEGER         NOT NULL REFERENCES vehicules(id),
    id_chauffeur            INTEGER         NOT NULL REFERENCES utilisateurs(id),
    date_heure_depart       TIMESTAMP       NOT NULL,
    duree_estimee_minutes   INTEGER         NOT NULL CHECK (duree_estimee_minutes > 0),
    tarif                   NUMERIC(10, 2)  NOT NULL CHECK (tarif >= 0)
);


CREATE TABLE client (
    id        SERIAL PRIMARY KEY,
    nom       VARCHAR(150) NOT NULL,
    telephone VARCHAR(20)  NOT NULL UNIQUE
);


CREATE TABLE statut_paiement (
    id      SERIAL PRIMARY KEY,
    libelle VARCHAR(50) NOT NULL
        CONSTRAINT chk_statut_paiement_libelle
        CHECK (libelle IN ('non-payé', 'partiellement payé', 'payé'))
);


CREATE TABLE reservations_mere (
    id                  SERIAL    PRIMARY KEY,
    libelle             VARCHAR(200) NOT NULL,
    id_voyage           INTEGER      NOT NULL REFERENCES voyages(id),
    id_client           INTEGER      NOT NULL REFERENCES client(id),
    date_reservation    TIMESTAMP    NOT NULL DEFAULT NOW(),
    id_statut_paiement  INTEGER      NOT NULL REFERENCES statut_paiement(id)
);

CREATE TABLE reservations_fille (
    id                  SERIAL  PRIMARY KEY,
    id_reservation_mere INTEGER NOT NULL REFERENCES reservations_mere(id),
    id_place            INTEGER NOT NULL REFERENCES places(id),
    UNIQUE (id_reservation_mere, id_place)
);