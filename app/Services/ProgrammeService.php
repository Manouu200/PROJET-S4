<?php
// app/Services/ProgrammeService.php
namespace App\Services;

use App\Models\PortefeuilleModel;
use App\Models\ProgrammeUtilisateurModel;
use App\Models\RegimeModel;
use Exception;

class ProgrammeService
{
    public static function validerPaiement($userId, $programmeData)
    {
        $db = db_connect();
        $db->transStart();
        try {
            $portefeuilleModel = new PortefeuilleModel();
            $programmeUtilisateurModel = new ProgrammeUtilisateurModel();

            // 1. Verifier le solde
            $portefeuille = $portefeuilleModel->where('id_utilisateur', $userId)->first();
            if (!$portefeuille) {
                throw new Exception("Portefeuille introuvable");
            }
            $solde = (float) $portefeuille['solde'];
            $prix = (float) ($programmeData['prix'] ?? 0);
            if ($prix <= 0) {
                throw new Exception("Prix invalide");
            }
            if ($solde < $prix) {
                throw new Exception("Solde insuffisant");
            }

            // 2. Verifier si deja un programme actif (optionnel, ici on laisse passer)

            // 3. Inserer dans programme_utilisateur
            $regimeId = $programmeData['id_regime'] ?? null;
            if (!$regimeId && !empty($programmeData['regime'])) {
                $regime = (new RegimeModel())->where('nom', (string) $programmeData['regime'])->first();
                if ($regime) {
                    $regimeId = $regime['id'] ?? null;
                }
            }

            $dataInsert = [
                'id_utilisateur' => $userId,
                'id_regime' => $regimeId,
                'id_activite' => $programmeData['id_activite'] ?? null,
                'date_decision' => date('Y-m-d'),
            ];
            if ($programmeUtilisateurModel->insert($dataInsert) === false) {
                throw new Exception("Insertion programme invalide");
            }

            // 4. Deduir le solde
            $portefeuille = $portefeuilleModel->getPortefeuille($userId);
            if ($portefeuille){
                // 1. débiter portefeuille
                $portefeuilleModel->update($portefeuille['id'], [
                    'solde' => $portefeuille['solde'] - $prix
                ]);
   
            }

            $portefeuilleMaj = $portefeuilleModel->where('id_utilisateur', $userId)->first();
            $nouveauSolde = isset($portefeuilleMaj['solde']) ? (float) $portefeuilleMaj['solde'] : null;
            $soldeAttendu = $solde - $prix;
            if ($nouveauSolde === null || abs($nouveauSolde - $soldeAttendu) > 0.01) {
                throw new Exception("Echec mise a jour du solde");
            }

            $db->transComplete();
            if ($db->transStatus() === false) {
                throw new Exception("Erreur transactionnelle");
            }
            return [
                'success' => true,
                'message' => 'Paiement valide et programme active.'
            ];
        } catch (Exception $e) {
            $db->transRollback();
            return [
                'success' => false,
                'message' => $e->getMessage()
            ];
        }
    }
}
