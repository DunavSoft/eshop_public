<?php

namespace Config;

use App\Modules\Routes\Models\RoutesModel;

// Create a new instance of our RouteCollection class.
$routes = Services::routes();

// Load the system's routing file first, so that the app and ENVIRONMENT
// can override as needed.
if (file_exists(SYSTEMPATH . 'Config/Routes.php')) {
	require SYSTEMPATH . 'Config/Routes.php';
}

/**
 * --------------------------------------------------------------------
 * Router Setup
 * --------------------------------------------------------------------
 */
//$routes->setDefaultNamespace('App\Modules\Land\Controllers');
$routes->setDefaultController('HomeController');
$routes->setDefaultMethod('index');
$routes->setTranslateURIDashes(false);

//all the redirects here
$redirectsModel = new \App\Modules\Redirects\Models\RedirectsModel;
$query = $redirectsModel->getElements();
foreach ($query as $row) {
	$routes->get($row->source, 'App\Modules\Redirects\Controllers\RedirectsController::handle404', ['filter' => 'redirects']);
}

//$routes->get('(.+)', 'App\Modules\Redirects\Controllers\RedirectsController::handle404', ['filter' => 'redirects']);

//$routes->get('([А-Яа-я]+)', 'App\Modules\Redirects\Controllers\RedirectsController::handle404', ['filter' => 'redirects']);

// Get the URI path
$currentUrl = current_url(true); // Returns an instance of CodeIgniter\HTTP\URI
$uriPath = $currentUrl->getPath();

// Get the URI object
$request = Services::request();
$uri = $request->uri;

// Get all segments as an array
$segments = $uri->getSegments();

// Load the App config
$config = new App();
$supportedLocales = $config->supportedLocales;

$localeVar = '';
if (!empty($segments) && in_array($segments[0], $supportedLocales)) {
    // Remove the locale from the segments
	$uriPath = str_replace($segments[0] . '/', '', $uriPath);
    $segments = array_slice($segments, 1);
	$localeVar = '{locale}/';
}

$routeModel = new RoutesModel();

//$routesArray = $routeModel->findAll();
if (!empty($segments) && isset($segments[0])) {
$individualRoute = $routeModel->findBySlug($segments[0]);

	// d($individualRoute);

	if ($individualRoute) {
		$routes->get($localeVar . $uriPath, 'App\Modules' . $individualRoute->route . '/' . $uriPath);

		if (count($segments) > 1) {
			$routes->get($localeVar . $segments[0] . '/(:num)', 'App\Modules' . $individualRoute->route . '/' . $segments[0] . '/$1');
		}
	}
}

if (empty($segments)) {
    $routes->get('/', 'App\Modules\Land\Controllers\HomeController::index');
	$routes->get('{locale}/', 'App\Modules\Land\Controllers\HomeController::index');
}

$routes->get('articles-all', 'App\Modules\Articles\Controllers\ArticlesController::articlesList/all');
$routes->get('{locale}/articles-all', 'App\Modules\Articles\Controllers\ArticlesController::articlesList/all');
$routes->get('articles-all/(:num)', 'App\Modules\Articles\Controllers\ArticlesController::articlesList/all/$1');
$routes->get('{locale}/articles-all/(:num)', 'App\Modules\Articles\Controllers\ArticlesController::articlesList/all/$1');
$routes->get('galleries-all', 'App\Modules\Galleries\Controllers\GalleriesController::galleriesList');
$routes->get('{locale}/galleries-all', 'App\Modules\Galleries\Controllers\GalleriesController::galleriesList');
$routes->get('products-all', 'App\Modules\Products\Controllers\ProductsController::productsList');
$routes->get('{locale}/products-all', 'App\Modules\Products\Controllers\ProductsController::productsList');
$routes->get('properties-all', 'App\Modules\Properties\Controllers\PropertiesController::propertiesList');
$routes->get('{locale}/properties-all', 'App\Modules\Properties\Controllers\PropertiesController::propertiesList');

$routes->get('favorites', 'App\Modules\Products\Controllers\ProductsController::favoritesList');

$routes->set404Override('App\Modules\Land\Controllers\ErrorsController::show404');
$routes->setAutoRoute(false);

/*
 * --------------------------------------------------------------------
 * Route Definitions
 * --------------------------------------------------------------------
 */

// We get a performance increase by specifying the default
// route since we don't have to scan directories.
////$routes->get('/', 'Home::index');

/**
 * --------------------------------------------------------------------
 * HMVC Routing
 * --------------------------------------------------------------------
 */

/*
foreach (glob(APPPATH . 'Modules/*', GLOB_ONLYDIR) as $item_dir) {
	if (file_exists($item_dir . '/Config/Routes.php')) {
		require_once($item_dir . '/Config/Routes.php');
	}
}
*/

/*
 * --------------------------------------------------------------------
 * Additional Routing
 * --------------------------------------------------------------------
 *
 * There will often be times that you need additional routing and you
 * need it to be able to override any defaults in this file. Environment
 * based routes is one such time. require() additional route files here
 * to make that happen.
 *
 * You will have access to the $routes object within that file without
 * needing to reload it.
 */

/*
if (file_exists(APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php')) {
	require APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php';
}
*/