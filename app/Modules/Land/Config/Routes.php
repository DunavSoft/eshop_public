<?php

if(!isset($routes))
{
    $routes = \Config\Services::routes(true);
}

//Front
$routes->group('', ['namespace' => 'App\Modules\Land\Controllers'], function($subroutes) {
	$subroutes->get('/', 'HomeController::index');
	$subroutes->post('/update_session', 'HomeController::update_session');
});

$routes->group('{locale}', ['namespace' => 'App\Modules\Land\Controllers', 'filter' => 'locale'], function($subroutes) {
    $subroutes->get('/', 'HomeController::index');
    $subroutes->post('update_session', 'HomeController::update_session');
});
