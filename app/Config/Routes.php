<?php

use CodeIgniter\Router\RouteCollection;

/** @var RouteCollection $routes */
$routes->get('/', function() {
    return redirect()->to('/login');
});


$routes->group('', ['filter' => 'operateurAuth'], function ($routes) {
    // Accueil
    $routes->get('operateur/accueil', 'Operateur::accueil');
    
    // Barèmes
    $routes->get('/baremes', 'BaremesFrais::index');
    $routes->get('/baremes/ajouter', 'BaremesFrais::ajouter');
    $routes->post('/baremes/ajouter', 'BaremesFrais::ajouter');
    $routes->get('/baremes/modifier/(:num)', 'BaremesFrais::modifier/$1');
    $routes->post('/baremes/modifier/(:num)', 'BaremesFrais::modifier/$1');
    $routes->get('/baremes/supprimer/(:num)', 'BaremesFrais::supprimer/$1');
    $routes->get('/baremes/situation', 'BaremesFrais::situation');
    
    // Clients
    $routes->get('/clients/situation', 'Clients::situation');




    // Préfixes
    $routes->get('prefixes', 'Prefixes::index');
    $routes->get('prefixes/ajouter', 'Prefixes::ajouter');
    $routes->post('prefixes/ajouter', 'Prefixes::ajouter');
    $routes->get('prefixes/modifier/(:num)', 'Prefixes::modifier/$1');
    $routes->post('prefixes/modifier/(:num)', 'Prefixes::modifier/$1');
    $routes->get('prefixes/supprimer/(:num)', 'Prefixes::supprimer/$1');



    $routes->get('operateurs/profil', 'Operateurs::profil');
$routes->post('operateurs/profil', 'Operateurs::profil');
$routes->get('baremes/reversements', 'BaremesFrais::reversements');
});


// Routes publiques (client)
$routes->get('login', 'Auth::login');
$routes->post('login', 'Auth::login');
$routes->get('logout', 'Auth::logout');
$routes->get('client/espace', 'Client::espace');
$routes->get('client/depot', 'Client::depot');
$routes->post('client/depot/traitement', 'Client::traitementDepot');
$routes->get('client/retrait', 'Client::retrait');
$routes->post('client/retrait/traitement', 'Client::traitementRetrait');
$routes->get('client/transfert', 'Client::transfert');
$routes->post('client/transfert/traitement', 'Client::traitementTransfert');
$routes->get('client/historique', 'Client::historique');

// Routes d'authentification opérateur
$routes->get('operateur/login', 'OperateurAuth::login');
$routes->post('operateur/login', 'OperateurAuth::login');
$routes->get('operateur/logout', 'OperateurAuth::logout');