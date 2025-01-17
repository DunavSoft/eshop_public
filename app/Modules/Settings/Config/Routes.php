<?php
if(!isset($routes))
{ 
    $routes = \Config\Services::routes(true);
}

$routes->group('{locale}/admin/settings', ['namespace' => 'App\Modules\Settings\Controllers'], function($subroutes) {
	/*** Route for Settings with locale ***/
	$subroutes->add('/', 'AdminSettingsController::index');
	$subroutes->add('index', 'AdminSettingsController::index');
	$subroutes->get('migrate', 'Migrate::index');
	$subroutes->get('migrate/regress/(:any)', 'Migrate::regress/$1');
	$subroutes->get('migrate/regress', 'Migrate::regress');
});

$routes->group('admin/settings', ['namespace' => 'App\Modules\Settings\Controllers'], function($subroutes) {
	/*** Route for Settings without locale ***/
    $subroutes->add('/', 'AdminSettingsController::index');
	$subroutes->add('index', 'AdminSettingsController::index');
	$subroutes->get('migrate', 'Migrate::index');
	$subroutes->get('migrate/regress/(:any)', 'Migrate::regress/$1');
	$subroutes->get('migrate/regress', 'Migrate::regress');
});