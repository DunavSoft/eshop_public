<?php namespace App\Modules\Users\Controllers;

/**
 * @version 1.0.0.0
 * @author Georgi Nechovski
 */

class Migrate extends BaseController
{
	public function __construct()
	{
		$this->languagesModel = model('App\Modules\Languages\Models\LanguagesModel', false);
	}

	public function index()
	{
		$migrate = \Config\Services::migrations();

		echo ' Migration for <b>Users</b> module start... <br />';

		try
		{
			$migrate->setNamespace('App\Modules\Users')->latest();

			$seeder = \Config\Database::seeder();
			$seeder->call('App\Modules\Users\Database\Seeds\SubscriptionSeeder');

			echo ' Migration for <b>Users</b> module complete...<br />';
		}
		catch (\Throwable $e)
		{
			echo 'Something wrong!';
			echo $e;
		}
	}

	public function regress($nrSteps = -1)
	{
		$migrate = \Config\Services::migrations();

		echo ' Regress Migration for <b>Users</b> module start... <br />';

		try
		{
			$migrate->setNamespace('App\Modules\Users')->regress($nrSteps, 'default');

			echo ' Regress Migration for <b>Users</b> module complete...<br />';
		}
		catch (\Throwable $e)
		{
			echo 'Something wrong!<br />';
			echo $e;
		}
	}
}
