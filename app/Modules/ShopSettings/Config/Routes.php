<?php
if(!isset($routes))
{ 
    $routes = \Config\Services::routes(true);
}

$routes->group('{locale}/admin/shopsettings', ['namespace' => 'App\Modules\ShopSettings\Controllers'], function($subroutes) {
	/*** Route for ShopSettings with locale ***/
	$subroutes->add('/', 'ShopSettingsController::index');
	$subroutes->add('index', 'ShopSettingsController::index');
	$subroutes->get('migrate', 'Migrate::index');
	$subroutes->get('migrate/regress/(:any)', 'Migrate::regress/$1');
	$subroutes->get('migrate/regress', 'Migrate::regress');
});

$routes->group('admin/shopsettings', ['namespace' => 'App\Modules\ShopSettings\Controllers'], function($subroutes) {
	/*** Route for ShopSettings without locale ***/
    $subroutes->add('/', 'ShopSettingsController::index');
	$subroutes->add('index', 'ShopSettingsController::index');
	$subroutes->get('migrate', 'Migrate::index');
	$subroutes->get('migrate/regress/(:any)', 'Migrate::regress/$1');
	$subroutes->get('migrate/regress', 'Migrate::regress');
});