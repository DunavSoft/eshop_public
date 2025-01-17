<?php namespace App\Modules\Properties\Controllers;

/**
 * @version 1.0.0.0
 * @author Georgi Nechovski
 * @edited on 2023-04-26
 */
 
use CodeIgniter\Controller;
use Throwable;

class Migrate extends BaseController
{
	public function __construct() 
	{
		//$this->languagesModel = model('App\Modules\Languages\Models\LanguagesModel', false);
	}

	public function index() 
	{
		$migrate = \Config\Services::migrations();

		echo ' Migration for <b>Properties</b> module start... <br />';

		try
		{
			$migrate->setNamespace('App\Modules\Properties')->latest();
			
			echo ' Migration for <b>Properties</b> module complete...<br />';
			
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

		echo ' Regress Migration for <b>Properties</b> module start... <br />';

		try
		{
			$migrate->setNamespace('App\Modules\Properties')->regress($nrSteps, 'default');
			
			echo ' Regress Migration for <b>Properties</b> module complete...<br />';
		}
		catch (\Throwable $e)
		{
			echo 'Something wrong!<br />';
			echo $e;
		}
	}

	public function reinstall()
	{
		if (ENVIRONMENT === 'development') {
			$migrate = \Config\Services::migrations();

			echo ' Reinstall for <b>Properties</b> module start... <br />';

			$db = Database::connect();
			$forge = \Config\Database::forge();

			$db->table('migrations')->delete(['namespace' => 'App\Modules\Properties']);

			// Drop the Properties table
			$forge->dropTable('properties_images', true);
			$forge->dropTable('properties_languages', true);
			$forge->dropTable('properties_categories_languages', true);
			$forge->dropTable('properties_categories_images', true);
			$forge->dropTable('properties_categories', true);
			$forge->dropTable('properties', true);

			try {
				$migrate->setNamespace('App\Modules\Properties')->latest();

				echo ' Migration for <b>Properties</b> module complete...<br />';

				echo ' Reinstall for <b>Properties</b> module complete...<br />';
			} catch (\Throwable $e) {
				echo 'Something wrong!<br />';
				echo $e;
			}
		} else {
			echo ' Reinstall for <b>Properties</b> module is disabled by the settings.<br />';
		}
	}
}