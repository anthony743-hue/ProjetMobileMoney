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