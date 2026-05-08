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
}
