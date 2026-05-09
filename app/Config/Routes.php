<?php

use CodeIgniter\Router\RouteCollection;

/** @var RouteCollection $routes */

$routes->get('/', function () {
    return redirect()->to('/login');
});

// Authentification
$routes->get('/login', 'AuthController::login');
$routes->post('/authenticate', 'AuthController::authenticate');
$routes->get('/logout', 'AuthController::logout');

// Inscription 
$routes->get('/inscription/etape1', 'InscriptionController::inscription_etape1');
$routes->post('/inscription/etape2', 'InscriptionController::inscription_etape2');
$routes->post('/inscription/finaliser', 'InscriptionController::finaliser');


$routes->get('/inscription/etape2', 'InscriptionController::inscription_etape1');
$routes->get('/inscription/finaliser', 'InscriptionController::inscription_etape1');

// API
$routes->post('/api/check-email', 'InscriptionController::checkEmail');

// Groupe Client 
$routes->group('client', ['filter' => 'auth'], function ($routes) {
    $routes->get('home', 'ClientController::index');
    $routes->get('page/(:segment)', 'ClientController::page/$1');
   
});

// Groupe Admin 
$routes->group('admin', ['filter' => 'admin'], function ($routes) {
    $routes->get('dashboard', 'AdminController::index');
    

    $routes->get('regimes', 'RegimeController::index');
    $routes->get('regimes/create', 'RegimeController::create'); 
    $routes->post('regimes/store', 'RegimeController::store');
    $routes->get('regimes/edit/(:num)', 'RegimeController::edit/$1');
    $routes->post('regimes/update/(:num)', 'RegimeController::update/$1');
    $routes->get('regimes/delete/(:num)', 'RegimeController::delete/$1');
    
    // Ajoute ici le CRUD pour les Activités Sportives plus tard
});