-- Utilisateur admin pour test - mot de passe: admin1234
INSERT INTO utilisateurs (nom, prenom, date_naissance, genre, email, mot_de_passe, est_gold, role) 
VALUES ('Admin', 'Test', '1990-01-01', 'M', 'admin@test.com', '$2y$10$d4qs/dzrqmU5DpS1J.8zKe8mPsCuzObqPSW2tle1IGR.Xdofkjmgy', 0, 'ADMIN');

-- Utilisateur client pour test - mot de passe: client1234
INSERT INTO utilisateurs (nom, prenom, date_naissance, genre, email, mot_de_passe, est_gold, role) 
VALUES ('Client', 'Test', '1995-05-15', 'F', 'client@test.com', '$2y$10$TjIbaC50b0xRZomrIUCk6OWH.8Y2DG4rwAqRkd664pJ0TKUaFBtHi', 0, 'CLIENT');

INSERT INTO portefeuille (id_utilisateur, solde) 
VALUES 
    (2, 5.0); -- on force le solde de Client a $5.00


-- Codes de recharges

INSERT INTO code_recharge (code, montant) 
VALUES 
    ('CODE5-001', 5),
    ('CODE5-002', 5),
    ('CODE5-003', 5),
    ('CODE5-004', 5),
    ('CODE5-005', 5),
    ('CODE10-001', 10),
    ('CODE10-002', 10),
    ('CODE10-003', 10),
    ('CODE10-004', 10),
    ('CODE10-005', 10),
    ('CODE20-001', 20),
    ('CODE20-002', 20),
    ('CODE20-003', 20),
    ('CODE20-004', 20),
    ('CODE20-005', 20);
-- Utilisateur client pour test - mot de passe: client1234
INSERT INTO utilisateurs (nom, prenom, date_naissance, genre, email, mot_de_passe, est_gold, role) 
VALUES ('Client2', 'Test', '1995-05-15', 'F', 'client2@test.com', '$2y$10$TjIbaC50b0xRZomrIUCk6OWH.8Y2DG4rwAqRkd664pJ0TKUaFBtHi', 0, 'CLIENT');

INSERT INTO historique_sante (id_utilisateur, poids, taille, date_mesure)
VALUES (2, 70.50, 175, CURDATE());

INSERT INTO historique_sante (id_utilisateur, poids, taille, date_mesure)
VALUES (3, 100, 150, CURDATE());
