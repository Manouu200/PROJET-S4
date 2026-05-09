<?php 

namespace App\Controllers;

class RegimeController extends BaseController
{

    public function create()
    {
        return view('admin/regimes/create');
    }
}