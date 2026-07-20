<?php

use CodeIgniter\Router\RouteCollection;

/** @var RouteCollection $routes */
$routes->get('/', 'Home::index');

$routes->get('/baremes', 'BaremesFrais::index');
$routes->get('/baremes/ajouter', 'BaremesFrais::ajouter');
$routes->post('/baremes/ajouter', 'BaremesFrais::ajouter');
$routes->get('/baremes/modifier/(:num)', 'BaremesFrais::modifier/$1');
$routes->post('/baremes/modifier/(:num)', 'BaremesFrais::modifier/$1');
$routes->get('/baremes/supprimer/(:num)', 'BaremesFrais::supprimer/$1');


$routes->get('baremes/situation', 'BaremesFrais::situation');
$routes->get('clients/situation', 'Clients::situation');


$routes->get('login', 'Auth::login');
$routes->post('login', 'Auth::login');
$routes->get('logout', 'Auth::logout');
$routes->get('client/espace', 'Client::espace');




$routes->get('client/depot', 'Client::depot');
$routes->post('client/depot/traitement', 'Client::traitementDepot');
$routes->get('client/retrait', 'Client::retrait');
$routes->post('client/retrait/traitement', 'Client::traitementRetrait');