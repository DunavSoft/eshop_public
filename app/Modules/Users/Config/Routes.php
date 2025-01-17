<?php

if (!isset($routes)) {
	$routes = \Config\Services::routes(true);
}

// Admin endpoints
$defineAdminUsersRoutes = function ($subroutes) {
	$subroutes->get('', 'UsersController::index');
	$subroutes->get('(:num)', 'UsersController::index/$1');
	$subroutes->get('(:num)/deleted', 'UsersController::index/$1/deleted');
	$subroutes->get('search/(:num)', 'UsersController::search/$1');
	$subroutes->post('search', 'UsersController::search');
	$subroutes->add('form/', 'UsersController::form/new');
    $subroutes->add('form/(:num)/(:num)', 'UsersController::form/$1/$2');
    $subroutes->add('form/(:any)', 'UsersController::form/$1');
	$subroutes->add('form_submit/(:any)', 'UsersController::form_submit/$1');
	$subroutes->get('delete/(:num)', 'UsersController::delete/$1');
	$subroutes->get('delete/(:num)/(:num)', 'UsersController::delete/$1/$2');
	$subroutes->get('restore/(:num)', 'UsersController::restore/$1');

	$subroutes->get('subscriptions/search/(:num)', 'SubscriptionsController::search/$1');
	$subroutes->post('subscriptions/search', 'SubscriptionsController::search');
	$subroutes->get('subscriptions/(:num)', 'SubscriptionsController::showSubscribersList/$1');
	$subroutes->get('subscriptions/form/(:num)', 'SubscriptionsController::form/$1');
	$subroutes->post('subscriptions/form_submit/(:any)', 'SubscriptionsController::form_submit/$1');
	$subroutes->get('subscriptions', 'SubscriptionsController::showSubscribersList');

	////???$subroutes->post('send/emails', 'SubscriptionsController::sendSubscriptionEmails');

	$subroutes->get('migrate', 'Migrate::index');
};

$defineFrontUsersRoutes = function ($subroutes) {
	$subroutes->get('login', 'AccountController::showLogin');
	$subroutes->post('login', 'AccountController::attemptLogin');

	$subroutes->get('logout', 'AccountController::logout');

	$subroutes->get('register', 'AccountController::showRegister');
	$subroutes->post('register', 'AccountController::attemptRegister');

	$subroutes->get('password/reset', 'AccountController::showPasswordReset');
	$subroutes->get('password/reset/(:any)', 'AccountController::resetPassword/$1');
	$subroutes->get('activate/(:any)', 'AccountController::showActivationPage/$1');
	$subroutes->post('password/reset', 'AccountController::resetPassword');
	$subroutes->post('password/change', 'AccountController::changePassword');
	$subroutes->post('password/new', 'AccountController::setNewCustomerPassword');

	$subroutes->get('myaccount', 'AccountController::showMyAccount');
	$subroutes->get('order/(:num)', 'AccountController::showOrder/$1');
	$subroutes->post('account/edit', 'AccountController::editAccount');

	$subroutes->post('emailsubscribe', 'SubscriptionsController::emailSubscribe');
	$subroutes->get('unsubscribe/(:any)', 'SubscriptionsController::attemptUnsubscription/$1');

	$subroutes->get('logout', 'AccountController::logout');
};

$routes->group('admin/users', ['namespace' => 'App\Modules\Users\Controllers'], function ($subroutes) use ($defineAdminUsersRoutes) {
	$defineAdminUsersRoutes($subroutes);
});

$routes->group('{locale}/admin/users', ['namespace' => 'App\Modules\Users\Controllers'], function ($subroutes) use ($defineAdminUsersRoutes) {
	$defineAdminUsersRoutes($subroutes);
});

// Storefront endpoints
$routes->group('{locale}/users', ['namespace' => 'App\Modules\Users\Controllers'], function ($subroutes) use ($defineFrontUsersRoutes) {
	$defineFrontUsersRoutes($subroutes);
});

$routes->group('users', ['namespace' => 'App\Modules\Users\Controllers'], function ($subroutes) use ($defineFrontUsersRoutes) {
	$defineFrontUsersRoutes($subroutes);
});
