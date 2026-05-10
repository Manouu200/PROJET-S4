<?php

namespace App\Services;

use App\Models\HistoriqueRemisesGoldModel;
use App\Models\PaiementsGoldEffectuesModel;
use App\Models\UtilisateurModel;
use App\Models\PortefeuilleModel;

class GoldService
{

    // TODO
    public function payerAbonnementGold(int $idUtilisateur): array
    {
        if ($this->isGold($idUtilisateur)) {
            return [
                'isSuccess' => false,
                'details'   => 'Déjà membre GOLD'
            ];
        }

        $soldeService        = new SoldeService();
        $goldModel           = new HistoriqueRemisesGoldModel();
        $paiementModel       = new PaiementsGoldEffectuesModel();
        $utilisateurModel    = new UtilisateurModel();
        $portefeuilleModel   = new PortefeuilleModel();

        $offreGold = $goldModel->getInfosActuelGold();

        if (!$offreGold) {
            return [
                'isSuccess' => false,
                'details'   => 'Aucune offre GOLD disponible'
            ];
        }

        $prixGold = (float) $offreGold['prix'];

        $portefeuille = $portefeuilleModel->getPortefeuille($idUtilisateur);

        if (!$portefeuille || $portefeuille['solde'] < $prixGold) {
            return [
                'isSuccess' => false,
                'details'   => 'Solde insuffisant'
            ];
        }

        $db = \Config\Database::connect();
        $db->transStart();

        // 1. débiter portefeuille
        $portefeuilleModel->update($portefeuille['id'], [
            'solde' => $portefeuille['solde'] - $prixGold
        ]);

        // 2. enregistrer paiement GOLD
        $paiementModel->insert([
            'id_utilisateur' => $idUtilisateur,
            'id_historique_remises_gold' => $offreGold['id']
        ]);

        // 3. passer utilisateur GOLD
        $utilisateurModel->update($idUtilisateur, [
            'est_gold' => 1
        ]);

        $db->transComplete();

        if ($db->transStatus() === false) {
            return [
                'isSuccess' => false,
                'details'   => 'Erreur lors du paiement GOLD'
            ];
        }

        return [
            'isSuccess' => true,
            'details'   => 'Abonnement GOLD activé avec succès'
        ];
    }

    public function isGold(int $idUtilisateur): bool
    {
        // d'abord on peut verifier dans utilisateurs.est_gold
        $utilisateurModel = new UtilisateurModel();
        if (!$utilisateurModel->estGold($idUtilisateur))
            return false;

        // puis on verifie dans la table paiements_gold_effectues par precaution
        $paiementsGolsModel = new PaiementsGoldEffectuesModel();
        if (!$paiementsGolsModel->isGold($idUtilisateur))
            return false;

        return true;
    }
}
