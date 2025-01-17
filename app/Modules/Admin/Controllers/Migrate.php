<?php namespace App\Modules\Admin\Controllers;

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

		echo ' Migration for <b>Admin</b> module start... <br />';

		try
		{
			$migrate->setNamespace('App\Modules\Admin')->latest();
			
			echo ' Seed for <b>Admin</b> module start...<br />';
		
			$seeder = \Config\Database::seeder();
			$seeder->call('App\Modules\Admin\Database\Seeds\AdminSeeder');
			
			echo ' Seed for <b>Admin</b> module complete...<br />';	
			echo ' Migration for <b>Admin</b> module complete...<br />';
		}
		catch (\Throwable $e)
		{
			echo 'Something wrong!';
			echo $e;
		}
	}
	
	public function regress($nrSteps = 0) 
	{
		$migrate = \Config\Services::migrations();

		echo ' Regress Migration for <b>Admin</b> module start... <br />';

		try
		{
			$migrate->setNamespace('App\Modules\Admin')->regress($nrSteps, 'default');
			
			echo ' Regress Migration for <b>Admin</b> module complete...<br />';
		}
		catch (\Throwable $e)
		{
			echo 'Something wrong!<br />';
			echo $e;
		}
	}
}