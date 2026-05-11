<?php

namespace App\Controllers;

use App\Models\Utilisateur;
use App\Models\UtilisateurModel;
use App\Models\RegimeModel;
use App\Models\ActiviteSportiveModel;
use App\Models\CodeRechargeModel;
use App\Models\HistoriqueRemisesGoldModel;

class AdminController extends BaseController
{
    public function index()
    {
        $utilisateurmodel = new UtilisateurModel();
        $activiteSportiveModel = new ActiviteSportiveModel();
        $regimeModel = new RegimeModel();
        $codeModel = new CodeRechargeModel();
        $codeStat = $codeModel->getCodeStats();
        $remisesModel = new HistoriqueRemisesGoldModel();
        $data = [
            'title' => 'Dashboard',
            'nombresClients' => $utilisateurmodel->getNombresClients(),
            'nombresRegimes' => $regimeModel->getNombresRegimes(),
            'nombresSports' => $activiteSportiveModel->getNombresSports(),
            'nombresClientsGold'=> $utilisateurmodel->getNombresClientsGold(),

            'nbCodesUtilises' => $codeStat['nbCodeUtilises'],
            'montantCodesUtilises' => $codeStat['montantCodesUtilises'],
            
            'nbCodesValides' => $codeStat['nbCodesValides'],
            'montantCodesValides' => $codeStat['montantCodesValides'],
            'remises' => $remisesModel->getInfosActuelGold()
        ];
        return view('admin/dashboard', $data);
    }

    public function list()
    {
        return view('admin/gestion-regimes');
    }


}
