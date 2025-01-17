<?php

namespace App\Modules\Routes\Controllers;

/**
 * @version 1.0.0.0
 * @author Ivelin Karayanev
 */

use Config\Database;

class Migrate extends BaseController
{
	protected $languagesModel;

	public function __construct()
	{
		$this->languagesModel = model('App\Modules\Languages\Models\LanguagesModel', false);
	}

	public function index()
	{
		$migrate = \Config\Services::migrations();

		echo ' Migration for <b>Routes</b> module start... <br />';

		try {
			$migrate->setNamespace('App\Modules\Routes')->latest();

			echo ' Migration for <b>Routes</b> module complete...<br />';
		} catch (\Throwable $e) {
			echo 'Something wrong!';
			echo $e;
		}
	}

	public function reinstall()
	{
		if (ENVIRONMENT === 'development') {
			$migrate = \Config\Services::migrations();

			echo ' Reinstall for <b>Routes</b> module start... <br />';

			$db = Database::connect();
			$forge = \Config\Database::forge();

			$db->table('migrations')->delete(['namespace' => 'App\Modules\Routes']);

			// Drop the articles table
			$forge->dropTable('routes', TRUE);

			try {
				$migrate->setNamespace('App\Modules\Routes')->latest();

				echo ' Migration for <b>Routes</b> module complete...<br />';

				echo ' Reinstall for <b>Routes</b> module complete...<br />';
			} catch (\Throwable $e) {
				echo 'Something wrong!<br />';
				echo $e;
			}
		} else {
			echo 'Reinstall for <b>Routes</b> module is disabled by the settings.<br />';
		}
	}
}