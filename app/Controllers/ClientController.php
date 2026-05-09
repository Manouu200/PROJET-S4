<?php

namespace App\Controllers;

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

        return view($allowedPages[$page]);
    }
}
