<?php

namespace App\Controllers;

use App\Models\Utilisateur;
use App\Models\UtilisateurModel;

class AdminController extends BaseController
{
    public function index()
    {
        $utilisateurmodel = new UtilisateurModel();
        $data = [
            'title' => 'Dashboard',
            'nombresClients' => $utilisateurmodel->getNombresClients(),
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
