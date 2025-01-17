<?php

if(!isset($routes))
{ 
    $routes = \Config\Services::routes(true);
}

$routes->group('admin', ['namespace' => 'App\Modules\Admin\Controllers'], function($subroutes) {
	
	$subroutes->add('login', 'LoginController::login');
	$subroutes->post('login', 'LoginController::attemptLogin');
    $subroutes->get('logout', 'LoginController::logout');

	/*** Route for Dashboard ***/
    $subroutes->get('', 'Dashboard::index');
	$subroutes->get('dashboard', 'Dashboard::index');
	
	/*** Route for Admin ***/
	$subroutes->get('administrators', 'AdminAdminController::index');
	$subroutes->get('administrators/deleted', 'AdminAdminController::index/$1');
    $subroutes->add('administrators/form/(:num)/(:num)', 'AdminAdminController::form/$1/$2');
    $subroutes->add('administrators/form/(:any)', 'AdminAdminController::form/$1');
    $subroutes->get('administrators/delete/(:num)', 'AdminAdminController::delete/$1');
    $subroutes->get('administrators/restore/(:num)', 'AdminAdminController::restore/$1');
	
	$subroutes->get('migrate', 'Migrate::index');
	$subroutes->get('migrate/regress/(:any)', 'Migrate::regress/$1');
	$subroutes->get('migrate/regress', 'Migrate::regress');
});

$routes->group('{locale}/admin', ['namespace' => 'App\Modules\Admin\Controllers'], function($subroutes) {

	$subroutes->add('login', 'LoginController::login');
	$subroutes->post('login', 'LoginController::attemptLogin');
    $subroutes->get('logout', 'LoginController::logout');

	/*** Route for Dashboard ***/
    $subroutes->add('', 'Dashboard::index');
	$subroutes->add('dashboard', 'Dashboard::index');
	
	/*** Route for Admin ***/
	$subroutes->get('administrators', 'AdminAdminController::index');
	$subroutes->get('administrators/deleted', 'AdminAdminController::index/deleted');
    $subroutes->add('administrators/form/(:num)/(:num)', 'AdminAdminController::form/$1/$2');
    $subroutes->add('administrators/form/(:any)', 'AdminAdminController::form/$1');
    $subroutes->get('administrators/delete/(:num)', 'AdminAdminController::delete/$1');
    $subroutes->get('administrators/restore/(:num)', 'AdminAdminController::restore/$1');
	
	$subroutes->get('migrate', 'Migrate::index');
	$subroutes->get('migrate/regress/(:any)', 'Migrate::regress/$1');
	$subroutes->get('migrate/regress', 'Migrate::regress');
});


$routes->group('/', ['namespace' => 'App\Modules\Admin\Controllers'], function($subroutes){
	$subroutes->get('login', 'LoginController::login');
	$subroutes->post('login', 'LoginController::attemptLogin');
    $subroutes->get('logout', 'LoginController::logout');
});

$routes->group('{locale}/', ['namespace' => 'App\Modules\Admin\Controllers'], function($subroutes){
	$subroutes->get('login', 'LoginController::login');
	$subroutes->post('login', 'LoginController::attemptLogin');
    $subroutes->get('logout', 'LoginController::logout');
});
/*
$routes->group('{locale}', ['namespace' => 'App\Modules\Admin\Controllers'], function($subroutes){
	$subroutes->add('login', 'LoginController::login');
    $subroutes->get('logout', 'LoginController::logout');
});
*/
