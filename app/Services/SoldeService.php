<?php

namespace App\Services;

use App\Models\PortefeuilleModel;
use App\Models\CodeRechargeModel;
use App\Models\HistoriqueRechargeModel;

class SoldeService
{

    public function getSoldeUtilisateur($idUtilisateur)
    {
        $portefeuilleModel = new PortefeuilleModel();
        $portefeuille = $portefeuilleModel->getPortefeuille($idUtilisateur);
        if (!$portefeuille) {
            return 0.0;
        }

        return (float) $portefeuille['solde'];
    }

    public function rechargerSolde($codeRecharge, $idUtilisateur)
    {
        $codeRecharge = trim((string) $codeRecharge);
        if ($codeRecharge === '') {
            return ['success' => false, 'message' => 'Code invalide'];
        }

        $codeModel = new CodeRechargeModel();
        $portefeuilleModel = new PortefeuilleModel();
        $historiqueModel = new HistoriqueRechargeModel();

        $code = $codeModel->getByCode($codeRecharge);
        if (! $code || (int) $code['est_utilise'] === 1) {
            return ['success' => false, 'message' => 'Code invalide'];
        }

        $portefeuille = $portefeuilleModel->getPortefeuille($idUtilisateur);
        if (! $portefeuille) {
            $portefeuilleId = $portefeuilleModel->insert([
                'id_utilisateur' => $idUtilisateur,
                'solde' => 0.0,
            ], true);
            $portefeuille = $portefeuilleModel->find($portefeuilleId);
        }

        $montant = (float) $code['montant'];
        $nouveauSolde = (float) $portefeuille['solde'] + $montant;
        $now = date('Y-m-d H:i:s');

        $db = \Config\Database::connect();
        $db->transStart();

        $portefeuilleModel->update($portefeuille['id'], [
            'solde' => $nouveauSolde,
        ]);

        $codeModel->update($code['id'], [
            'est_utilise' => 1,
            'id_utilisateur' => $idUtilisateur,
            'used_at' => $now,
        ]);

        $historiqueModel->insert([
            'id_portefeuille' => $portefeuille['id'],
            'id_code_utilise' => $code['id'],
            'montant' => $montant,
            'used_at' => $now,
        ]);

        $db->transComplete();

        if (! $db->transStatus()) {
            return ['success' => false, 'message' => 'Une erreur est survenue'];
        }

        return ['success' => true, 'message' => 'OK'];
    }

    public function isCodeRechargeValid($codeRecharge): bool
    {
        $codeModel = new CodeRechargeModel();
        $code = $codeModel->getByCode($codeRecharge);
        if (! $code) {
            return false;
        }

        return (int) $code['est_utilise'] !== 1;
    }
}
