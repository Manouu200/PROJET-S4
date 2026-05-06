<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');
$routes->post('/auth/authenticate', 'Auth::authenticate');
$routes->get('/inscription', 'Inscription::etape1');
$routes->post('/inscription/etape2', 'Inscription::etape2');
$routes->post('/inscription/finaliser', 'Inscription::finaliser');
$routes->get('/inscription/reset', 'Inscription::reset');
