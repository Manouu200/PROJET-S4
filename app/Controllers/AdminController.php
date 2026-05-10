<?php

namespace App\Controllers;

use App\Models\Utilisateur;
use App\Models\UtilisateurModel;
use App\Models\RegimeModel;
use App\Models\ActiviteSportiveModel;

class AdminController extends BaseController
{
    public function index()
    {
        $utilisateurmodel = new UtilisateurModel();
        $activiteSportiveModel = new ActiviteSportiveModel();
        $regimeModel = new RegimeModel();
        $data = [
            'title' => 'Dashboard',
            'nombresClients' => $utilisateurmodel->getNombresClients(),
            'nombresRegimes' => $regimeModel->getNombresRegimes(),
            'nombresSports' => $activiteSportiveModel->getNombresSports(),
            'nombresClientsGold'=> $utilisateurmodel->getNombresClientsGold()
        ];
        return view('admin/dashboard', $data);
    }

    public function list()
    {
        return view('admin/gestion-regimes');
    }

    // public function mdp_admin(){
    //     $mdp = password_hash('admin1234', PASSWORD_DEFAULT);
    //     echo $mdp;
    // }
}
