<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');
$routes->get('/home', 'Home::index');
$routes->get('/accueil', 'Home::accueil');
$routes->get('/login', 'Auth::showLogin');
$routes->post('/login', 'Auth::login');
$routes->get('/inscription', 'Auth::showRegister');
$routes->post('/inscription', 'Auth::register');
$routes->get('/inscription-sante', 'Auth::showRegisterHealth');
$routes->post('/inscription-sante', 'Auth::registerHealth');
$routes->post('/profil-sante', 'Home::saveProfilSante');
// $routes->get('/logout', 'Auth::logout');
