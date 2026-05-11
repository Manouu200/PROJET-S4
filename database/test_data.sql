-- =========================
-- 1. UTILISATEURS (base)
-- =========================

-- Admin test
INSERT INTO utilisateurs (nom, prenom, date_naissance, genre, email, mot_de_passe, est_gold, role) 
VALUES ('Admin', 'Test', '1990-01-01', 'M', 'admin@test.com', '$2y$10$d4qs/dzrqmU5DpS1J.8zKe8mPsCuzObqPSW2tle1IGR.Xdofkjmgy', 0, 'ADMIN');

-- Client test
INSERT INTO utilisateurs (nom, prenom, date_naissance, genre, email, mot_de_passe, est_gold, role) 
VALUES ('Client', 'Test', '1995-05-15', 'F', 'client@test.com', '$2y$10$TjIbaC50b0xRZomrIUCk6OWH.8Y2DG4rwAqRkd664pJ0TKUaFBtHi', 0, 'CLIENT');


-- =========================
-- 2. OBJECTIFS / IMC (indépendants mais utiles tôt)
-- =========================

INSERT INTO objectif (nom_objectif) VALUES
('Perdre du poids'),
('Prendre du poids'),
('Atteindre l''IMC idéal');

INSERT INTO imc (min, max, libelle) VALUES
(0, 18.5, 'Maigreur'),
(18.5, 25, 'Corpulence normale'),
(25, 30, 'Surpoids'),
(30, 999, 'Obésité');


-- =========================
-- 3. RÉGIMES
-- =========================

INSERT INTO regime (id, nom, pourcent_viande, pourcent_poisson, pourcent_volaille, poids_variation, duree_jours) VALUES
(1, 'Régime Hypocalorique Équilibré', 30, 30, 40, -2.00, 14),
(2, 'Régime Cétogène', 50, 20, 30, -4.50, 30),
(3, 'Régime Hypercalorique Musculation', 40, 20, 40, 3.00, 30),
(4, 'Régime Méditerranéen', 20, 50, 30, -1.50, 14),
(5, 'Régime Prise de Masse Intensive', 45, 15, 40, 5.00, 45);


-- =========================
-- 4. ACTIVITÉS SPORTIVES
-- =========================

INSERT INTO activite_sportive (nom, poids_variation) VALUES
('Marche rapide (150-180 min/semaine)', -0.30),
('Course a pied (90-120 min/semaine)', -0.60),
('Natation (2-3 seances/semaine)', -0.40),
('Cyclisme (2-3 sorties/semaine)', -0.45),
('HIIT (3 seances/semaine)', -0.70),
('Yoga dynamique (3 seances/semaine)', -0.20),
('Musculation prise de masse (3-4 seances/semaine)', 0.40),
('Musculation maintien (2-3 seances/semaine)', 0.10),
('Cross-training (3 seances/semaine)', -0.50),
('Repos actif (mobilite + marche)', -0.10);


-- =========================
-- 5. RÉGIME PRIX (dépend de regime)
-- =========================

INSERT INTO regime_prix (id_regime, duree_jours, prix) VALUES
(1, 14, 19.99),
(1, 30, 34.99),
(1, 60, 59.99),

(2, 14, 24.99),
(2, 30, 44.99),
(2, 60, 79.99),

(3, 14, 22.99),
(3, 30, 42.99),
(3, 60, 74.99),

(4, 14, 21.99),
(4, 30, 39.99),
(4, 60, 69.99),

(5, 30, 49.99),
(5, 45, 69.99),
(5, 90, 119.99);


-- =========================
-- 6. HISTORIQUE SANTÉ (dépend utilisateurs)
-- =========================

INSERT INTO historique_sante (id_utilisateur, poids, taille, date_mesure)
VALUES (2, 70.50, 175, CURDATE());


-- =========================
-- 7. PORTEFEUILLE (dépend utilisateurs)
-- =========================

INSERT INTO portefeuille (id_utilisateur, solde) 
VALUES (2, 5.00);


-- =========================
-- 8. CODES DE RECHARGE (indépendant)
-- =========================

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


-- =========================
-- 9. REMISES GOLD
-- =========================

INSERT INTO historique_remises_gold (prix, pourcent_remise, created_at)
VALUES (9.99, 10.0, '2026-05-09 14:30:00');

INSERT INTO historique_remises_gold (prix, pourcent_remise)
VALUES (14.99, 15.0);