<?php 

namespace App\Controllers;

use App\Services\AlgoSuggestion;

class ProgrammeController extends BaseController {

    public function show()
    {
        $algo = new \App\Services\AlgoSuggestion();

        $poidsIndividu = $this->request->getGet("poidsIndividu");
        $poidsMinCible = $this->request->getGet("poidsMin");
        $poidsMaxCible = $this->request->getGet("poidsMax");

        $resultats = $algo->suggererProgrammes(
            (float) $poidsIndividu,
            (float) $poidsMinCible,
            (float) $poidsMaxCible
        );

        return $this->response->setJSON($resultats);
    }

}

?>