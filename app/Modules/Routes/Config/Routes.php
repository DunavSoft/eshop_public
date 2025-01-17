<?php
/*
	Module: Routes
*/
if (!isset($routes)) {
    $routes = \Config\Services::routes(true);
}

$routesModule = function ($subroutes) {
    $subroutes->get('migrate', 'Migrate::index');
	$subroutes->get('reinstall', 'Migrate::reinstall');
};

$routes->group('{locale}/admin/routes', ['namespace' => 'App\Modules\Routes\Controllers'], function ($subroutes) use ($routesModule) {
    $routesModule($subroutes);
});

$routes->group('admin/routes', ['namespace' => 'App\Modules\Routes\Controllers'], function ($subroutes) use ($routesModule) {
    $routesModule($subroutes);
});