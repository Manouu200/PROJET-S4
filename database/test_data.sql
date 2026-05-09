-- Utilisateur admin pour test - mot de passe: admin1234
INSERT INTO utilisateurs (nom, prenom, date_naissance, genre, email, mot_de_passe, est_gold, role) 
VALUES ('Admin', 'Test', '1990-01-01', 'M', 'admin@test.com', '$2y$10$d4qs/dzrqmU5DpS1J.8zKe8mPsCuzObqPSW2tle1IGR.Xdofkjmgy', 0, 'ADMIN');

-- Utilisateur client pour test - mot de passe: client1234
INSERT INTO utilisateurs (nom, prenom, date_naissance, genre, email, mot_de_passe, est_gold, role) 
VALUES ('Client', 'Test', '1995-05-15', 'F', 'client@test.com', '$2y$10$TjIbaC50b0xRZomrIUCk6OWH.8Y2DG4rwAqRkd664pJ0TKUaFBtHi', 0, 'CLIENT');

INSERT INTO portefeuille (id_utilisateur, solde) 
VALUES 
    (2, 5.0); -- on force le solde de Client a $5.00