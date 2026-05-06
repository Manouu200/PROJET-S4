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
