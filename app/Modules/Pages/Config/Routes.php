<?php
/*
	Module: Pages
*/
if (!isset($routes)) {
    $routes = \Config\Services::routes(true);
}

$adminRoutes = function ($subroutes) {
    $subroutes->get('', 'AdminPagesController::index');
    $subroutes->get('(:num)', 'AdminPagesController::index/$1');
	$subroutes->get('deleted/(:num)', 'AdminPagesController::index/$1/1');
    
	$subroutes->add('form/', 'AdminPagesController::form/new');
    $subroutes->add('form/(:num)/(:num)', 'AdminPagesController::form/$1/$2');
	$subroutes->add('form/(:any)', 'AdminPagesController::form/$1');
	$subroutes->add('form_submit/(:any)', 'AdminPagesController::form_submit/$1');

	$subroutes->post('search/(:num)', 'AdminPagesController::search/$1');
	$subroutes->post('deleted/search/(:num)', 'AdminPagesController::search/$1/1');
	$subroutes->get('search/(:num)', 'AdminPagesController::search/$1');
	$subroutes->get('deleted/search/(:num)', 'AdminPagesController::search/$1/1');
	
    $subroutes->get('delete/(:num)', 'AdminPagesController::delete/$1');
    $subroutes->get('restore/(:num)', 'AdminPagesController::restore/$1');
	
	$subroutes->get('migrate', 'Migrate::index');
	$subroutes->get('reinstall', 'Migrate::reinstall');
};

$routes->group('{locale}/admin/pages', ['namespace' => 'App\Modules\Pages\Controllers'], function ($subroutes) use ($adminRoutes) {
    $adminRoutes($subroutes);
});

$routes->group('admin/pages', ['namespace' => 'App\Modules\Pages\Controllers'], function ($subroutes) use ($adminRoutes) {
    $adminRoutes($subroutes);
});