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
$routes->match(['get', 'post'], 'connexion', 'Connexion::connect');
$routes->match(['get', 'post'], 'inscription', 'Inscription::index');	
$routes->match(['post'], 'cours', 'Courses::search');

$routes->get('/', 'Home::index');
$routes->get('cours', 'Courses::index');
$routes->get('/dashbord', 'Dashboard::index');
$routes->get('/deconnexion', 'Connexion::deconnect');
$routes->get('cours/(:segment)', 'Courses::show/$1');
$routes->get('/formations/(:segment)', 'Home::show');

$routes->match(['get', 'post'], 'admin', 'admins/adminConnexion::connect');
$routes->match(['get', 'post'], 'admin/connexion', 'admins/adminConnexion::connect');
$routes->match(['post'], 'admin/dashbord', 'admins/adminDashboard::search');

$routes->get('admin/deconnexion', 'admins/adminConnexion::deconnect');
$routes->get('admin/dashboard', 'admins/adminDashboard::index');

// $routes->match(['get', 'post'], 'cours/create', 'Courses::create');
// $routes->get('(:any)', 'Pages::view/$1');
// $routes->get('/Courses/', 'Courses::view');

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
