
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