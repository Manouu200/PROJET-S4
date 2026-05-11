<?php 

namespace App\Controllers;

use App\Models\UtilisateurModel;
use App\Models\HistoriqueRemisesGoldModel;
use App\Services\AlgoSuggestion;
use App\Services\ProgrammeService;

class ProgrammeController extends BaseController {

    public function validerPaiement()
    {
        if (!$this->request->isAJAX()) {
            return $this->response
                ->setStatusCode(400)
                ->setJSON(['success' => false, 'message' => 'Requête invalide']);
        }

        $userId = session()->get('user_id');
        if (!$userId) {
            return $this->response
                ->setStatusCode(401)
                ->setJSON(['success' => false, 'message' => 'Non authentifié']);
        }

        $programmeData = $this->request->getJSON(true);
        $result = ProgrammeService::validerPaiement($userId, $programmeData);

        return $this->response->setJSON($result);
    }

    // Affiche la page de paiement (infos du programme récupérées côté JS)
    public function payer()
    {
        return view('client/pages/payer_programme');
    }

    public function show()
    {
        $algo = new \App\Services\AlgoSuggestion();

        $poidsIndividu = $this->request->getPost("poidsIndividu");
        $poidsMinCible = $this->request->getPost("poidsMin");
        $poidsMaxCible = $this->request->getPost("poidsMax");

        $resultats = $algo->suggererProgrammes(
            (float) $poidsIndividu,
            (float) $poidsMinCible,
            (float) $poidsMaxCible
        );

        $estGold = (new UtilisateurModel())->estGold(session()->get('user_id'));
        if ($estGold){
            $remiseGold = (new HistoriqueRemisesGoldModel())->getInfosActuelGold()['pourcent_remise'];
            for ($i = 0; $i < count($resultats); $i++){
                $resultats[$i]['prix'] = ((float) $resultats[$i]['prix']) * (100. - $remiseGold) / 100.;
            }
        }

        return $this->response->setJSON($resultats);
    }

}

?>