<?php namespace App\Modules\Settings\Controllers;

/**
 * @version 1.1.0.0
 * @author Georgi Nechovski
 */
 
use CodeIgniter\Controller;
use Throwable;

class Migrate extends BaseController
{
	public function __construct() 
	{
		$this->languagesModel = model('App\Modules\Languages\Models\LanguagesModel', false);
	}

	public function index() 
	{
		$migrate = \Config\Services::migrations();

		echo ' Migration for <b>Settings</b> module start... <br />';

		try
		{
			$migrate->setNamespace('App\Modules\Settings')->latest();
			
			echo ' Migration for <b>Settings</b> module complete...<br />';
			
			//echo $migrate->status();
		}
		catch (\Throwable $e)
		{
			echo 'Something wrong!<br />';
			echo $e;
		}
	}
	
	public function regress($nrSteps = 0) 
	{
		$migrate = \Config\Services::migrations();

		echo ' Regress Migration for <b>Settings</b> module start... <br />';

		try
		{
			$migrate->setNamespace('App\Modules\Settings')->regress($nrSteps);
			
			echo ' Regress Migration for <b>Settings</b> module complete...<br />';
		}
		catch (\Throwable $e)
		{
			echo 'Something wrong!<br />';
			echo $e;
		}
	}
}
