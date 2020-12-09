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

//FrontEnd
$routes->setDefaultNamespace('App\Controllers\FrontEnd');

$routes->get('/', 'HomeController::home');
$routes->get('/formations/(:segment)', 'HomeController::showTraining/$1');
$routes->get('/connexion', 'ConnectionController::connection');
$routes->get('/deconnexion', 'ConnectionController::disconnection');
// $routes->get('/inscription', 'RegistrationController::registration');
$routes->get('/inscription/(:segment)', 'RegistrationController::registration/$1');
$routes->get('/cours', 'Courses::index');
$routes->post('/cours', 'Courses::search');
$routes->get('/cours/(:segment)', 'Courses::show/$1');

$routes->get('/dashboard', 'DashboardController::dashboard');



// $routes->match(['get', 'post'], 'admin', 'admins/adminConnexion::connect');
// $routes->match(['get', 'post'], 'admin/connexion', 'admins/adminConnexion::connect');
// $routes->get('admin/deconnexion', 'admins/adminConnexion::deconnect');

// $routes->match(['post'], 'admin/dashbord', 'admins/adminDashboard::search');
// $routes->get('admin/dashboard', 'admins/adminDashboard::index');


//Apis
$routes->setDefaultNamespace('App\Controllers\Apis');

//Connexion
$routes->post('/apis/users/connexion', 'ConnectionController::userConnection');
$routes->post("/apis/session/connect/(:segment)", "SessionController::connect/$1");

//Users
$routes->get('/apis/users', 'UsersController::getAllUser');
$routes->get('/apis/users/get/(:segment)', 'UsersController::getUser/$1');
$routes->post('/apis/users/store/(:segment)', 'UsersController::storeUser/$1');
$routes->post('/apis/users/update/(:segment)', 'UsersController::updateUser/$1');
$routes->get('/apis/users/delete/(:segment)', 'UsersController::deleteUser/$1');

//Products
$routes->get('/apis/products', 'ProductsController::getAllProduct');
$routes->get('/apis/products/get/(:segment)', 'ProductsController::getProduct/$1');
$routes->post('/apis/products/store', 'ProductsController::storeProduct');
$routes->post('/apis/products/update/(:segment)', 'ProductsController::updateProduct/$1');
$routes->get('/apis/products/delete/(:segment)', 'ProductsController::deleteProduct/$1');

//Packages
$routes->get('/apis/packages', 'PackagesController::getAllPackage');
$routes->get('/apis/packages/get/(:segment)', 'PackagesController::getPackage/$1');
$routes->post('/apis/packages/store', 'PackagesController::storePackage');
$routes->post('/apis/packages/update/(:segment)', 'PackagesController::updatePackage/$1');
$routes->get('/apis/packages/delete/(:segment)', 'PackagesController::deletePackage/$1');

//SubscribedPackages
$routes->get('/apis/subscribedPackages', 'SubscribedPackagesController::getAllSubscribedPackage');
$routes->get('/apis/subscribedPackages/get/(:segment)', 'SubscribedPackagesController::getSubscribedPackage/$1');
$routes->post('/apis/subscribedPackages/store', 'SubscribedPackagesController::storeSubscribedPackage');
$routes->post('/apis/subscribedPackages/update/(:segment)', 'SubscribedPackagesController::storeSubscribedPackage/$1');
$routes->get('/apis/subscribedPackages/delete/(:segment)', 'SubscribedPackagesController::deleteSubscribedPackage/$1');

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
