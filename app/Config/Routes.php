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
$routes->post('/objectifs', 'Home::saveObjectifs');
$routes->post('/wallet/recharge', 'Wallet::recharge');
$routes->post('/wallet/gold', 'Wallet::buyGold');
$routes->post('/regimes/choose', 'Home::saveRegime');
$routes->get('/export/pdf', 'Export::userPdf');
$routes->get('/admin/regimes', 'Regimes::index');
$routes->get('/admin/regimes/create', 'Regimes::create');
$routes->post('/admin/regimes/store', 'Regimes::store');
$routes->get('/admin/regimes/edit/(:num)', 'Regimes::edit/$1');
$routes->post('/admin/regimes/update/(:num)', 'Regimes::update/$1');
$routes->post('/admin/regimes/delete/(:num)', 'Regimes::delete/$1');
$routes->get('/admin/activites', 'Activites::index');
$routes->get('/admin/activites/create', 'Activites::create');
$routes->post('/admin/activites/store', 'Activites::store');
$routes->get('/admin/activites/edit/(:num)', 'Activites::edit/$1');
$routes->post('/admin/activites/update/(:num)', 'Activites::update/$1');
$routes->post('/admin/activites/delete/(:num)', 'Activites::delete/$1');
$routes->get('/admin/parametres', 'Parametres::index');
$routes->get('/admin/parametres/create', 'Parametres::create');
$routes->post('/admin/parametres/store', 'Parametres::store');
$routes->get('/admin/parametres/edit/(:num)', 'Parametres::edit/$1');
$routes->post('/admin/parametres/update/(:num)', 'Parametres::update/$1');
$routes->post('/admin/parametres/delete/(:num)', 'Parametres::delete/$1');
$routes->get('/admin/users', 'Users::index');
$routes->get('/admin/users/(:num)', 'Users::show/$1');
$routes->get('/logout', 'Auth::logout');
