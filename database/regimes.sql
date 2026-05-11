
INSERT INTO regime (id, nom, pourcent_viande, pourcent_poisson, pourcent_volaille, poids_variation, duree_jours) VALUES
(1, 'Régime Hypocalorique Équilibré', 30, 30, 40, -2.00, 14), -- -2kg/14j
(2, 'Régime Cétogène', 50, 20, 30, -4.50, 30), -- -4.5kg/30j
(3, 'Régime Hypercalorique Musculation', 40, 20, 40, 3.00, 30), -- +3kg/30j
(4, 'Régime Méditerranéen', 20, 50, 30, -1.50, 14), -- -1.5kg/14j
(5, 'Régime Prise de Masse Intensive', 45, 15, 40, 5.00, 45); -- +5kg/45j   

-- Régime 1 : Hypocalorique Équilibré
INSERT INTO regime_prix (id_regime, duree_jours, prix) VALUES
(1, 14, 19.99),
(1, 30, 34.99),
(1, 60, 59.99);

-- Régime 2 : Cétogène
INSERT INTO regime_prix (id_regime, duree_jours, prix) VALUES
(2, 14, 24.99),
(2, 30, 44.99),
(2, 60, 79.99);

-- Régime 3 : Hypercalorique Musculation
INSERT INTO regime_prix (id_regime, duree_jours, prix) VALUES
(3, 14, 22.99),
(3, 30, 42.99),
(3, 60, 74.99);

-- Régime 4 : Méditerranéen
INSERT INTO regime_prix (id_regime, duree_jours, prix) VALUES
(4, 14, 21.99),
(4, 30, 39.99),
(4, 60, 69.99);

-- Régime 5 : Prise de Masse Intensive
INSERT INTO regime_prix (id_regime, duree_jours, prix) VALUES
(5, 30, 49.99),
(5, 45, 69.99),
(5, 90, 119.99);    

-- Activites sportives (variation de poids par semaine en kg)
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