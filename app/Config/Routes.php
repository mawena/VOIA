<?php

namespace Config;

// Create a new instance of our RouteCollection class.
$routes = Services::routes();

// Load the system's routing file first, so that the app and ENVIRONMENT
// can override as needed.
if (file_exists(SYSTEMPATH . 'Config/Routes.php')) {
	require SYSTEMPATH . 'Config/Routes.php';
}

/**
 * --------------------------------------------------------------------
 * Router Setup
 * --------------------------------------------------------------------
 */
$routes->setDefaultNamespace('App\Controllers');
$routes->setDefaultController('Home');
$routes->setDefaultMethod('index');
$routes->setTranslateURIDashes(false);
$routes->set404Override();
$routes->setAutoRoute(true);

/**
 * --------------------------------------------------------------------
 * Route Definitions
 * --------------------------------------------------------------------
 */

// We get a performance increase by specifying the default
// route since we don't have to scan directories.
$routes->match(['get', 'post'], 'inscription', 'Inscription::index');
$routes->match(['get', 'post'], 'connexion', 'Connexion::index');
$routes->match(['post'], 'formations', 'Training::search');
$routes->match(['get', 'post'], 'formations/create', 'Training::create');
$routes->get('/', 'Home::index');
$routes->get('formations/(:segment)', 'Training::show/$1');
$routes->get('formations', 'Training::index');
$routes->get('/rebrique/(:segment)', 'Home::show');
$routes->get('/dashbord', 'Dashboard::index');
$routes->get('/deconnexion', 'Connexion::deconnect');

// $routes->get('(:any)', 'Pages::view/$1');
// $routes->get('/Training/', 'Training::view');

/**
 * --------------------------------------------------------------------
 * Additional Routing
 * --------------------------------------------------------------------
 *
 * There will often be times that you need additional routing and you
 * need it to be able to override any defaults in this file. Environment
 * based routes is one such time. require() additional route files here
 * to make that happen.
 *
 * You will have access to the $routes object within that file without
 * needing to reload it.
 */
if (file_exists(APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php')) {
	require APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php';
}
