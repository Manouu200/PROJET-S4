<?php
use CodeIgniter\Router\RouteCollection;

/** @var RouteCollection $routes */

$routes->get('/', function() { return redirect()->to('/login'); });
$routes->get('/login', 'AuthController::login');
$routes->post('/authenticate', 'AuthController::authenticate');
$routes->get('/logout', 'AuthController::logout');
$routes->get('/inscription/etape1', 'InscriptionController::inscription_etape1');
$routes->post('/inscription/etape2', 'InscriptionController::inscription_etape2');
$routes->post('/inscription/finaliser', 'InscriptionController::finaliser');
$routes->post('/api/check-email', 'InscriptionController::checkEmail');


//  Groupe Client 
$routes->group('client', ['filter' => 'auth'], function($routes) {
    $routes->get('/', 'ClientController::index');
    $routes->get('home', 'ClientController::index');
    
});

//  Groupe Admin 
$routes->group('admin', ['filter' => 'admin'], function($routes) {
    $routes->get('dashboard', 'AdminController::index');
  
});