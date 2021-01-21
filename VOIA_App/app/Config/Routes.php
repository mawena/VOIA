<?php

namespace Config;

use App\Controller\FrontEnd\SuperAdminsController;

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
$routes->get('/connexion/passwordrecovery', 'ConnectionController::passwordRecovery');
$routes->get('/deconnexion', 'ConnectionController::disconnection');
$routes->get("/admin/connexion", "SuperAdminsController::superAdminConnexion");

$routes->get('/inscription', 'RegistrationController::registration');
$routes->get('/inscription/(:segment)/(:segment)', 'RegistrationController::registration/$1/$2');

// $routes->get('/cours', 'CoursesController::index');
$routes->post('/cours', 'CoursesController::search');
$routes->get('/cours/(:segment)', 'CoursesController::show/$1');
$routes->get('/cours/list/(:segment)', 'CoursesController::getCoursesByTrainingGroup/$1');

$routes->get('/dashboard', 'DashboardController::dashboard');
$routes->get("/admin/dashboard", "SuperAdminsController::superAdminDashboard");
$routes->post("/admin/dashboard", "SuperAdminsController::superAdminDashboardSearch");



// $routes->match(['get', 'post'], 'admin', 'admins/adminConnexion::connect');
// $routes->match(['get', 'post'], 'admin/connexion', 'admins/adminConnexion::connect');
// $routes->get('admin/deconnexion', 'admins/adminConnexion::deconnect');

// $routes->match(['post'], 'admin/dashbord', 'admins/adminDashboard::search');
// $routes->get('admin/dashboard', 'admins/adminDashboard::index');


//Apis
$routes->setDefaultNamespace('App\Controllers\Apis');

//Connexion
$routes->post('/apis/users/connexion', 'ConnectionController::userConnection');
$routes->post("/apis/superadmins/connexion", "ConnectionController::superAdminConnection");
$routes->post("/apis/session/users/connect/(:segment)", "SessionController::userConnect/$1");
$routes->post("/apis/session/superadmins/connect/(:segment)", "SessionController::superAdminConnect/$1");
$routes->post('/apis/users/getByUsername', 'ConnectionController::getByUsername');


//Users
$routes->get('/apis/users', 'UsersController::getAllUser');
$routes->get('/apis/users/commerciaux', "UsersController::getAllCommercialUser");
$routes->get('/apis/users/get/(:segment)', 'UsersController::getUser/$1');
$routes->post('/apis/users/store', 'UsersController::storeUser/$1');
$routes->post('/apis/users/update/(:segment)', 'UsersController::updateUser/$1');
$routes->get('/apis/users/delete/(:segment)', 'UsersController::deleteUser/$1');
$routes->get("/apis/parains/get/(:segment)", "UsersController::getParain/$1");
$routes->get('/apis/users/godFather/godDauhters/(:segment)', "UsersController::getAllGodDauhter/$1");
$routes->post("/apis/users/search", "UsersController::searchUser");

//UsersWaiting
$routes->get('/apis/userswaiting', 'UsersWaitingController::getAllUserWaiting');
$routes->get('/apis/userswaiting/get/(:segment)', 'UsersWaitingController::getUserWaiting/$1');
$routes->post('/apis/userswaiting/store', 'UsersWaitingController::storeUserWaiting/$1');
// $routes->post('/apis/userswaiting/update/(:segment)', 'UsersWaitingController::updateUserWaiting/$1');
$routes->get('/apis/userswaiting/delete/(:segment)', 'UsersWaitingController::deleteUserWaiting/$1');
$routes->get("/apis/userswaiting/validate/(:segment)", "UsersWaitingController::validateUserWaiting/$1");

//Products
$routes->get('/apis/products', 'ProductsController::getAllProduct');
$routes->get('/apis/products/get/(:segment)', 'ProductsController::getProduct/$1');
// $routes->post('/apis/products/store', 'ProductsController::storeProduct');
// $routes->post('/apis/products/update/(:segment)', 'ProductsController::updateProduct/$1');
// $routes->get('/apis/products/delete/(:segment)', 'ProductsController::deleteProduct/$1');

//Packages
$routes->get('/apis/packages', 'PackagesController::getAllPackage');
$routes->get('/apis/packages/get/(:segment)', 'PackagesController::getPackage/$1');
$routes->post('/apis/packages/store', 'PackagesController::storePackage');
// $routes->post('/apis/packages/update/(:segment)', 'PackagesController::updatePackage/$1');
// $routes->get('/apis/packages/delete/(:segment)', 'PackagesController::deletePackage/$1');

//SubscribedPackages
$routes->get('/apis/subscribedPackages', 'SubscribedPackagesController::getAllSubscribedPackage');
$routes->get('/apis/subscribedPackages/get/(:segment)', 'SubscribedPackagesController::getSubscribedPackage/$1');
// $routes->post('/apis/subscribedPackages/store', 'SubscribedPackagesController::storeSubscribedPackage');
// $routes->post('/apis/subscribedPackages/update/(:segment)', 'SubscribedPackagesController::storeSubscribedPackage/$1');
// $routes->get('/apis/subscribedPackages/delete/(:segment)', 'SubscribedPackagesController::deleteSubscribedPackage/$1');
$routes->get("/apis/subscribedPackages/users/get/(:segment)", "SubscribedPackagesController::getUserSubscribedPackage/$1");

//Sponsorships
$routes->get('/apis/sponsorships/', "SponsorshipsController::getAllSponsorship");
$routes->get('/apis/sponsorships/get/(:segment)', "SponsorshipsController::getSponsorship/$1");
$routes->get('/apis/sponsorships/godFather/get/(:segment)', "SponsorshipsController::getgodFatherSponsorship/$1");
// $routes->post('/apis/sponsorships/store', "SponsorshipsController::storeSponsorship");
// $routes->post('/apis/sponsorships/update/(:segment)', "SponsorshipsController::updateSponsorship/$1");
// $routes->get('/apis/sponsorships/delete/(:segment)', "SponsorshipsController::deleteSponsorship/$1");


// Hold current page

$routes->get("/apis/session/setCurrentPage/(:segment)", "SessionController::holdCurrentPage/$1");

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
