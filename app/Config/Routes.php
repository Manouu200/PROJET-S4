<?php

use CodeIgniter\Router\RouteCollection;

/** @var RouteCollection $routes */

$routes->get('/', function () {
    return redirect()->to('/login');
});
$routes->get('/login', 'AuthController::login');
$routes->post('/authenticate', 'AuthController::authenticate');
$routes->get('/logout', 'AuthController::logout');
$routes->get('/inscription/etape1', 'InscriptionController::inscription_etape1');
$routes->post('/inscription/etape2', 'InscriptionController::inscription_etape2');
$routes->post('/inscription/finaliser', 'InscriptionController::finaliser');
$routes->post('/api/check-email', 'InscriptionController::checkEmail');

// Route de test simple (sans filtre) pour déboguer
$routes->get('/test/accueil', function () {
    return view('client/pages/acceuil');
});


//  Groupe Client 
$routes->group('client', ['filter' => 'auth'], function ($routes) {
    $routes->get('home', 'ClientController::index');
});

// Route pour charger les pages client (sans pagecache, filtre auth appliqué avant le routeur)
$routes->get('client/page/(:segment)', 'ClientController::page/$1', ['filter' => 'auth']);

//  Groupe Admin 
$routes->group('admin', ['filter' => 'admin'], function ($routes) {
    $routes->get('dashboard', 'AdminController::index');
    $routes->get('regimes/create', 'RegimeController::create');
    $routes->post('regimes/store', 'RegimeController::store');
});
