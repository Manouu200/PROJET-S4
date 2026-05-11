<?php

use CodeIgniter\Router\RouteCollection;

/** @var RouteCollection $routes */

$routes->get('/', function () {
    return redirect()->to('/login');
});
$routes->get('/login', 'AuthController::login');
$routes->post('/authenticate', 'AuthController::authenticate');
$routes->get('/logout', 'AuthController::logout');
$routes->match(['GET', 'POST'], '/inscription/etape1', 'InscriptionController::inscription_etape1');
$routes->match(['GET', 'POST'], '/inscription/etape2', 'InscriptionController::inscription_etape2');
$routes->post('/inscription/finaliser', 'InscriptionController::finaliser');
$routes->post('/api/check-email', 'InscriptionController::checkEmail');

// Groupe Client 
$routes->group('client', ['filter' => 'auth'], function ($routes) {
    $routes->get('home', 'ClientController::index');
    $routes->get('regimes', 'ClientController::regimes');
    $routes->get('regimes/calculer', 'ClientController::calculerObjectif');
    $routes->get('page/(:segment)', 'ClientController::page/$1');
    $routes->group('solde', function ($routes) {
        $routes->post('recharge', 'SoldeController::rechargerSolde');
        $routes->post('recharger', 'SoldeController::rechargerSolde');
    });

    $routes->get('profil', 'ClientController::edit');
    $routes->post('profil/update', 'ClientController::update');
    $routes->post('gold/payer', 'GoldController::payer');
    $routes->post('programmes/obtenir-suggestions', 'ProgrammeController::show');
    $routes->get('programmes/payer', 'ProgrammeController::payer');
    $routes->post('programmes/valider-paiement', 'ProgrammeController::validerPaiement');
});

// Groupe Admin 
$routes->group('admin', ['filter' => 'admin'], function ($routes) {
    $routes->get('dashboard', 'AdminController::index');

    // regimes
    $routes->get('regimes', 'RegimeController::index');
    $routes->get('regimes/create', 'RegimeController::create');
    $routes->post('regimes/store', 'RegimeController::store');
    $routes->get('regimes/edit/(:num)', 'RegimeController::edit/$1');
    $routes->post('regimes/update/(:num)', 'RegimeController::update/$1');
    $routes->get('regimes/delete/(:num)', 'RegimeController::delete/$1');

    // sports
    $routes->get('sports', 'ActiviteSportiveController::index');
    $routes->get('sports/create', 'ActiviteSportiveController::create');
    $routes->post('sports/store', 'ActiviteSportiveController::store');
    $routes->get('sports/edit/(:num)', 'ActiviteSportiveController::edit/$1');
    $routes->post('sports/update/(:num)', 'ActiviteSportiveController::update/$1');
    $routes->get('sports/delete/(:num)', 'ActiviteSportiveController::delete/$1');

    // codes de recharges
    $routes->get('codes', 'CodeRechargeController::index');
    $routes->get('codes/create', 'CodeRechargeController::create');
    $routes->post('codes/store', 'CodeRechargeController::store');
    $routes->get('codes/delete/(:num)', 'CodeRechargeController::delete/$1');

    // IMC
    $routes->get('imc', 'IMCController::index');          // Liste
    $routes->get('imc/create', 'IMCController::create');   // Formulaire Ajout
    $routes->post('imc/store', 'IMCController::store');    // Action Ajout
    $routes->get('imc/edit/(:num)', 'IMCController::edit/$1'); // Formulaire Edit
    $routes->post('imc/update/(:num)', 'IMCController::update/$1'); // Action Edit
    $routes->get('imc/delete/(:num)', 'IMCController::delete/$1');
});
