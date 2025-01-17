<?php
if(!isset($routes))
{
    $routes = \Config\Services::routes(true);
}

$routes->group('admin/redirects', ['namespace' => 'App\Modules\Redirects\Controllers'], function($subroutes) {
	/*** Route for Redirects ***/
	$subroutes->get('/', 'RedirectsController::index');
	$subroutes->get('index/(:num)', 'RedirectsController::index/$1');
	
	$subroutes->get('deleted', 'RedirectsController::index/1/deleted');
	$subroutes->get('deleted/(:num)', 'RedirectsController::index/$1/deleted');
	
	$subroutes->post('search', 'RedirectsController::search');
	$subroutes->get('search/(:num)', 'RedirectsController::search/$1');

    $subroutes->add('form/', 'RedirectsController::form/new');
    $subroutes->add('form/(:num)/(:num)', 'RedirectsController::form/$1/$2');
    $subroutes->add('form/(:any)', 'RedirectsController::form/$1');
    $subroutes->add('form_submit/(:any)', 'RedirectsController::form_submit/$1');
    $subroutes->get('delete/(:num)', 'RedirectsController::delete/$1');
	$subroutes->get('restore/(:num)', 'RedirectsController::restore/$1');
	
	$subroutes->get('migrate', 'Migrate::index');
	$subroutes->get('migrate/regress/(:any)', 'Migrate::regress/$1');
	$subroutes->get('migrate/regress', 'Migrate::regress');
});

$routes->group('{locale}/admin/redirects', ['namespace' => 'App\Modules\Redirects\Controllers'], function($subroutes) {
	/*** Route for Redirects ***/
	$subroutes->get('/', 'RedirectsController::index/1');
	$subroutes->get('(:num)', 'RedirectsController::index/$1');
	
	$subroutes->get('deleted', 'RedirectsController::index/1/deleted');
	$subroutes->get('deleted/(:num)', 'RedirectsController::index/$1/deleted');
	
	$subroutes->post('search', 'RedirectsController::search');
	$subroutes->get('search/(:num)', 'RedirectsController::search/$1');
   
	$subroutes->add('form/', 'RedirectsController::form/new');
    $subroutes->add('form/(:num)/(:num)', 'RedirectsController::form/$1/$2');
    $subroutes->add('form/(:any)', 'RedirectsController::form/$1');
	$subroutes->add('form_submit/(:any)', 'RedirectsController::form_submit/$1');
    $subroutes->get('delete/(:num)', 'RedirectsController::delete/$1');
    $subroutes->get('restore/(:num)', 'RedirectsController::restore/$1');
	
	$subroutes->get('migrate', 'Migrate::index');
	$subroutes->get('migrate/regress/(:any)', 'Migrate::regress/$1');
	$subroutes->get('migrate/regress', 'Migrate::regress');
});