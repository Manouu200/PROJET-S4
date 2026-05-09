<?php 

namespace App\Services;

use App\Models\PortefeuilleModel;

class SoldeService {

    public function getSoldeUtilisateur($idUtilisateur){
        $portefeuilleModel = new PortefeuilleModel();
        $solde = $portefeuilleModel->getPortefeuille($idUtilisateur)['solde'];

        return $solde;
    }

}

?>