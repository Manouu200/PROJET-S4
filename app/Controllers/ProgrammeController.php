<?php 

namespace App\Controllers;

use App\Models\UtilisateurModel;
use App\Models\HistoriqueRemisesGoldModel;
use App\Services\AlgoSuggestion;

class ProgrammeController extends BaseController {

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