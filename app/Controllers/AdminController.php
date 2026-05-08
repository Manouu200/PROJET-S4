<?php

namespace App\Controllers;

class AdminController extends BaseController
{
    public function index()
    {
        $data = [
            'user_nom' => session()->get('user_nom'),
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
