<?php

namespace App\Controllers;

use App\Services\SoldeService;

class ClientController extends BaseController
{
    public function index()
    {
        $data = [
            'user_nom' => session()->get('user_nom'),
        ];
        return view('client/home', $data);
    }


    public function page(string $page)
    {
        $allowedPages = [
            'accueil' => 'client/pages/acceuil',
            'regimes' => 'client/pages/regimes',
            'edit' => 'client/pages/edit',
            'programme' => 'client/pages/programme',
            'solde' => 'client/pages/solde',
            'gold' => 'client/pages/gold',
        ];

        if (! array_key_exists($page, $allowedPages)) {
            return $this->response->setStatusCode(404);
        }

        $data = [];

        switch ($page) {
            case 'solde':
                $service = new SoldeService(); 
                $data['solde'] = $service->getSoldeUtilisateur(session()->get('user_id'));
                break;
            
            default:
                # code...
                break;
        }

        return view($allowedPages[$page], $data);
    }
}
