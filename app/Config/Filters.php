<?php

namespace Config;

use CodeIgniter\Config\BaseConfig;

class Filters extends BaseConfig
{
	// Makes reading things below nicer,
	// and simpler to change out script that's used.
	public $aliases = [
		'csrf'     => \CodeIgniter\Filters\CSRF::class,
		'toolbar'  => \CodeIgniter\Filters\DebugToolbar::class,
		'honeypot' => \CodeIgniter\Filters\Honeypot::class,
		'admin'    => \App\Filters\AdminAuthFilter::class,
		'languages' => \App\Modules\Languages\Filters\LanguagesFilter::class,
		'main_menu' => \App\Modules\Menus\Filters\MainMenuFilter::class,
		'settings' 	=> \App\Modules\Settings\Filters\SettingsFilter::class,
		'shop_settings' => \App\Modules\ShopSettings\Filters\ShopSettingsFilter::class,
		'galleries' => \App\Modules\Galleries\Filters\GalleriesFilter::class,
		'dynamic_forms' => \App\Modules\DynamicForms\Filters\DynamicFormsFilter::class,
		'redirects' => \App\Modules\Redirects\Filters\RedirectsFilter::class,
		'payments' => \App\Modules\Payments\Filters\PaymentsSettingsFilter::class,
		'category_menu' => \App\Modules\Products\Filters\CategoryMenuFilter::class,
		'locale' => \App\Filters\LocaleFilter::class,
		'mainLanguageRedirect' => \App\Filters\MainLanguageRedirectFilter::class,
	];

	// Always applied before every request
	public $globals = [
		'before' => [
			//'honeypot'
			// 'csrf',
			'mainLanguageRedirect',
			'redirects' => ['except' => ['install',]],
		],
		'after'  => [
			'toolbar',
			'languages' => ['except' => ['admin/*', 'bg/admin/*', 'en/admin/*']],
			'category_menu' => ['except' => ['admin/*', 'bg/admin/*', 'en/admin/*']],
			'main_menu' => ['except' => ['admin/*', 'bg/admin/*', 'en/admin/*']],
			'settings' => ['except' => ['admin/*', 'bg/admin/*', 'en/admin/*']],
			'shop_settings' => ['except' => ['admin/*', 'bg/admin/*', 'en/admin/*']],
			'galleries' => ['except' => ['admin/*', 'bg/admin/*', 'en/admin/*']],
			'dynamic_forms' => ['except' => ['admin/*', 'bg/admin/*', 'en/admin/*']],
			'payments' => ['except' => ['admin/*', 'bg/admin/*', 'en/admin/*']],

			//'honeypot',
		],
	];

	// Works on all of a particular HTTP method
	// (GET, POST, etc) as BEFORE filters only
	//     like: 'post' => ['CSRF', 'throttle'],
	public $methods = [];

	// List filter aliases and any before/after uri patterns
	// that they should run on, like:
	public $filters = [
		'admin' => [
			'before' => ['admin', 'bg/admin', 'en/admin', 'admin/*', 'bg/admin/*', 'en/admin/*'],
			'except' => ['/', 'admin/login', 'admin/login/*', 'en/admin/login', 'bg/admin/login']
		],
	];
}