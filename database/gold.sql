CREATE TABLE historique_remises_gold (
    id INT AUTO_INCREMENT PRIMARY KEY,
    prix DECIMAL(10,2) NOT NULL,
    pourcent_remise DECIMAL(5,2) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

INSERT INTO historique_remises_gold (prix, pourcent_remise, created_at)
VALUES (9.99, 10.0, '2026-05-09 14:30:00');

INSERT INTO historique_remises_gold (prix, pourcent_remise)
VALUES (14.99, 15.0);

CREATE TABLE paiements_gold_effectues (
    id INT AUTO_INCREMENT PRIMARY KEY,
    id_utilisateur INT NOT NULL,
    id_historique_remises_gold INT NOT NULL,
    date_paiement TIMESTAMP DEFAULT CURRENT_TIMESTAMP,

    FOREIGN KEY (id_historique_remises_gold)
        REFERENCES historique_remises_gold(id),
    FOREIGN KEY (id_utilisateur)
        REFERENCES utilisateurs(id)
);