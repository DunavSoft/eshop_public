<?php
/*
	Module: Galleries
*/
if (!isset($routes)) {
    $routes = \Config\Services::routes(true);
}

$adminRoutes = function ($subroutes) {
	/*** Route for GalleriesController ***/
    $subroutes->add('/', 'GalleriesController::index');
	$subroutes->add('index/(:num)', 'GalleriesController::index/$1');
    
	$subroutes->add('form/', 'GalleriesController::form/new');
	$subroutes->add('form/new', 'GalleriesController::form/new');
    $subroutes->add('form/(:num)/(:num)', 'GalleriesController::form/$1/$2');
    $subroutes->add('form/(:num)', 'GalleriesController::form/$1');
	
	$subroutes->add('form/ajax', 'GalleriesController::form/ajax/new');
    $subroutes->add('form/ajax/(:num)/(:num)', 'GalleriesController::form/ajax/$1/$2');
    $subroutes->add('form/ajax/(:num)', 'GalleriesController::form/ajax/$1');
	
    $subroutes->add('delete/(:num)', 'GalleriesController::delete/$1');
    $subroutes->add('restore/(:num)', 'GalleriesController::restore/$1');

	$subroutes->post('process_ordering/(:num)', 'GalleriesController::process_ordering/$1');

	$subroutes->get('migrate', 'Migrate::index');
	$subroutes->get('reinstall', 'Migrate::reinstall');
};

$routes->group('{locale}/admin/galleries', ['namespace' => 'App\Modules\Galleries\Controllers'], function($subroutes) use ($adminRoutes) {
	$adminRoutes($subroutes);
});

$routes->group('admin/galleries', ['namespace' => 'App\Modules\Galleries\Controllers'], function($subroutes) use ($adminRoutes) {
	$adminRoutes($subroutes);
});