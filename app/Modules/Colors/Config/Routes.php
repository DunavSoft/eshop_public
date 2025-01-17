<?php
if(!isset($routes))
{
    $routes = \Config\Services::routes(true);
}

$routes->group('admin/colors', ['namespace' => 'App\Modules\Colors\Controllers'], function($subroutes) {
	/*** Route for Colors ***/
	$subroutes->get('/', 'ColorsController::index');
	$subroutes->get('index/(:num)', 'ColorsController::index/$1');
	//$subroutes->get('index_ajax/(:num)', 'ColorsController::index_ajax/$1');
    $subroutes->add('form/', 'ColorsController::form/new');
    $subroutes->add('form/(:num)/(:num)', 'ColorsController::form/$1/$2');
    $subroutes->add('form/(:any)', 'ColorsController::form/$1');
    $subroutes->add('form_submit/(:any)', 'ColorsController::form_submit/$1');
    $subroutes->get('delete/(:num)', 'ColorsController::delete/$1');
	$subroutes->get('restore/(:num)', 'ColorsController::restore/$1');
	
	$subroutes->get('migrate', 'Migrate::index');
	$subroutes->get('reinstall', 'Migrate::reinstall');
});

$routes->group('{locale}/admin/colors', ['namespace' => 'App\Modules\Colors\Controllers'], function($subroutes) {
	/*** Route for Colors ***/
	$subroutes->get('/', 'ColorsController::index/1');
	$subroutes->get('(:num)', 'ColorsController::index/$1');
	
	$subroutes->get('deleted', 'ColorsController::index/1/deleted');
	$subroutes->get('deleted/(:num)', 'ColorsController::index/$1/deleted');
	
	//$subroutes->get('index_ajax/(:num)', 'ColorsController::index_ajax/$1');
	//$subroutes->get('index_ajax/', 'ColorsController::index_ajax/1');
	
	$subroutes->post('search', 'ColorsController::search');
	$subroutes->get('search/(:num)', 'ColorsController::search/$1');
   
	$subroutes->add('form/', 'ColorsController::form/new');
    $subroutes->add('form/(:num)/(:num)', 'ColorsController::form/$1/$2');
    $subroutes->add('form/(:any)', 'ColorsController::form/$1');
	$subroutes->add('form_submit/(:any)', 'ColorsController::form_submit/$1');
    $subroutes->get('delete/(:num)', 'ColorsController::delete/$1');
    $subroutes->get('restore/(:num)', 'ColorsController::restore/$1');
	
	$subroutes->get('migrate', 'Migrate::index');
	$subroutes->get('reinstall', 'Migrate::reinstall');
});