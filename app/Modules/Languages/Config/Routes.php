<?php

if(!isset($routes))
{ 
    $routes = \Config\Services::routes(true);
}

$routes->group('{locale}/admin/languages', ['namespace' => 'App\Modules\Languages\Controllers'], function($subroutes) {
    $subroutes->get('/', 'LanguagesController::index');
    $subroutes->post('/', 'LanguagesController::index');
   
	$subroutes->get('migrate', 'Migrate::index');
	$subroutes->get('reinstall', 'Migrate::reinstall');
});
$routes->group('admin/languages', ['namespace' => 'App\Modules\Languages\Controllers'], function($subroutes) {
	$subroutes->get('/', 'LanguagesController::index');
    $subroutes->post('/', 'LanguagesController::index');

	$subroutes->get('migrate', 'Migrate::index');
	$subroutes->get('reinstall', 'Migrate::reinstall');
});