DROP DATABASE IF EXISTS regime;
CREATE DATABASE IF NOT EXISTS regime;
USE regime;

CREATE TABLE utilisateurs (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nom VARCHAR(100) NOT NULL,
    prenom VARCHAR(100) NOT NULL,
    date_naissance DATE,
    genre ENUM('M', 'F', 'AUTRE'),
    email VARCHAR(150) UNIQUE NOT NULL,
    mot_de_passe VARCHAR(255) NOT NULL,
    est_gold BOOLEAN DEFAULT FALSE,
    role ENUM('CLIENT', 'ADMIN') DEFAULT 'CLIENT'
);

CREATE TABLE historique_sante (
    id INT AUTO_INCREMENT PRIMARY KEY,
    id_utilisateur INT NOT NULL,
    poids DECIMAL(5,2),      -- ex: 70.50 kg
    taille DECIMAL(5,2),     -- ex: 1.75 m
    date_mesure DATE,
    FOREIGN KEY (id_utilisateur) REFERENCES utilisateurs(id)
        ON DELETE CASCADE
        ON UPDATE CASCADE
);

CREATE TABLE objectif (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nom_objectif VARCHAR(100)
);

CREATE TABLE objectifs_utilisateur (
    id INT AUTO_INCREMENT PRIMARY KEY,
    id_utilisateur INT,
    id_objectif INT,
    date_choix DATE,
    FOREIGN KEY (id_utilisateur) REFERENCES utilisateurs(id),
    FOREIGN KEY (id_objectif) REFERENCES objectif(id)
);

CREATE TABLE regime (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nom VARCHAR(100),
    pourcent_viande INT,
    pourcent_poisson INT,
    pourcent_volaille INT,
    poids_variation DECIMAL(5,2), -- + ou -
    duree_jours INT
);

CREATE TABLE regime_prix (
    id INT AUTO_INCREMENT PRIMARY KEY,
    id_regime INT,
    duree_jours INT,
    prix DECIMAL(10,2),
    FOREIGN KEY (id_regime) REFERENCES regime(id)
);

CREATE TABLE activite_sportive (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nom VARCHAR(100),
    poids_variation DECIMAL(5,2) -- + ou -
);

-- PS: on ajoutera des lignes a cette table que si le paiement pour le programme est approuve
CREATE TABLE programme_utilisateur (
    id INT AUTO_INCREMENT PRIMARY KEY,
    id_utilisateur INT,
    id_regime INT,
    id_activite INT,
    date_decision DATE,
    FOREIGN KEY (id_utilisateur) REFERENCES utilisateurs(id),
    FOREIGN KEY (id_regime) REFERENCES regime(id),
    FOREIGN KEY (id_activite) REFERENCES activite_sportive(id)
);

CREATE TABLE portefeuille (
    id INT AUTO_INCREMENT PRIMARY KEY,
    id_utilisateur INT NOT NULL UNIQUE,
    solde DECIMAL(12,2) DEFAULT 0.00,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (id_utilisateur) REFERENCES utilisateurs(id)
        ON DELETE CASCADE
        ON UPDATE CASCADE
);

CREATE TABLE code_recharge (
    id INT AUTO_INCREMENT PRIMARY KEY,
    code VARCHAR(100) NOT NULL UNIQUE,
    montant DECIMAL(12,2) NOT NULL,
    est_utilise BOOLEAN DEFAULT FALSE,
    id_utilisateur INT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    used_at TIMESTAMP NULL,
    FOREIGN KEY (id_utilisateur) REFERENCES utilisateurs(id)
        ON DELETE SET NULL
        ON UPDATE CASCADE
);

CREATE TABLE historique_recharge (
    id INT AUTO_INCREMENT PRIMARY KEY,
    id_portefeuille INT NOT NULL,
    id_code_utilise INT NOT NULL UNIQUE,
    montant DECIMAL(12,2) NOT NULL,
    used_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,

    FOREIGN KEY (id_portefeuille) REFERENCES portefeuille(id)
        ON DELETE CASCADE
        ON UPDATE CASCADE,

    FOREIGN KEY (id_code_utilise) REFERENCES code_recharge(id)
        ON DELETE CASCADE
        ON UPDATE CASCADE
);