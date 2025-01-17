<?php
if(!isset($routes))
{
    $routes = \Config\Services::routes(true);
}

$definePropertiesCategoriesRoutes = function ($subroutes) {

	/*** Route for Properties ***/
	$subroutes->get('/', 'PropertiesCategoriesController::index/1');
	$subroutes->get('(:num)', 'PropertiesCategoriesController::index/$1');
	
	$subroutes->get('deleted', 'PropertiesCategoriesController::index/1/deleted');
	$subroutes->get('deleted/(:num)', 'PropertiesCategoriesController::index/$1/deleted');
	$subroutes->post('search', 'PropertiesCategoriesController::search');
	$subroutes->get('search/(:num)', 'PropertiesCategoriesController::search/$1');
	$subroutes->add('form/', 'PropertiesCategoriesController::form/new');
    $subroutes->add('form/(:num)/(:num)', 'PropertiesCategoriesController::form/$1/$2');
    $subroutes->add('form/(:any)', 'PropertiesCategoriesController::form/$1');
	$subroutes->add('form_submit/(:any)', 'PropertiesCategoriesController::form_submit/$1');
    $subroutes->get('delete/(:num)', 'PropertiesCategoriesController::delete/$1');
    $subroutes->get('restore/(:num)', 'PropertiesCategoriesController::restore/$1');
	
	//$subroutes->post('create_slug', 'PropertiesController::create_slug');
	$subroutes->post('validate_field', 'PropertiesCategoriesController::validateField');
	
	$subroutes->get('migrate', 'Migrate::index');
	$subroutes->get('reinstall', 'Migrate::reinstall');
};

$routes->group('{locale}/admin/properties_categories', ['namespace' => 'App\Modules\Properties\Controllers'], function ($subroutes) use ($definePropertiesCategoriesRoutes) {
	$definePropertiesCategoriesRoutes($subroutes);
});

$routes->group('admin/properties_categories', ['namespace' => 'App\Modules\Properties\Controllers'], function ($subroutes) use ($definePropertiesCategoriesRoutes) {
	$definePropertiesCategoriesRoutes($subroutes);
});

$definePropertiesRoutes = function ($subroutes) {


	/*** Route for Properties ***/
	$subroutes->get('/', 'PropertiesController::index/1');
	$subroutes->get('(:num)', 'PropertiesController::index/$1');
	
	$subroutes->get('deleted', 'PropertiesController::index/1/deleted');
	$subroutes->get('deleted/(:num)', 'PropertiesController::index/$1/deleted');
	$subroutes->post('search', 'PropertiesController::search');
	$subroutes->get('search/(:num)', 'PropertiesController::search/$1');
	$subroutes->add('form/', 'PropertiesController::form/new');
    $subroutes->add('form/(:num)/(:num)', 'PropertiesController::form/$1/$2');
    $subroutes->add('form/(:any)', 'PropertiesController::form/$1');
	$subroutes->add('form_submit/(:any)', 'PropertiesController::form_submit/$1');
    $subroutes->get('delete/(:num)', 'PropertiesController::delete/$1');
    $subroutes->get('restore/(:num)', 'PropertiesController::restore/$1');
	
	$subroutes->post('validate_field', 'PropertiesController::validateField');
	
	$subroutes->get('migrate', 'Migrate::index');
	$subroutes->get('reinstall', 'Migrate::reinstall');
};

$routes->group('{locale}/admin/properties', ['namespace' => 'App\Modules\Properties\Controllers'], function ($subroutes) use ($definePropertiesRoutes) {
	$definePropertiesRoutes($subroutes);
});

$routes->group('admin/properties', ['namespace' => 'App\Modules\Properties\Controllers'], function ($subroutes) use ($definePropertiesRoutes) {
	$definePropertiesRoutes($subroutes);
});

