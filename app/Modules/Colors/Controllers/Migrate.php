<?php namespace App\Modules\Colors\Controllers;

/**
 * @version 1.0.1
 * @author Georgi Nechovski
 * @edited on 2024-01-15
 */
 
use Config\Database;

class Migrate extends BaseController
{
	public function __construct() 
	{
		//$this->languagesModel = model('App\Modules\Languages\Models\LanguagesModel', false);
	}

	public function index() 
	{
		$migrate = \Config\Services::migrations();

		echo ' Migration for <b>Colors</b> module start... <br />';

		try
		{
			$migrate->setNamespace('App\Modules\Colors')->latest();
			
			echo ' Migration for <b>Colors</b> module complete...<br />';
			
			//echo $migrate->status();
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

			echo ' Reinstall for <b>Colors</b> module start... <br />';

			$db = Database::connect();
			$forge = \Config\Database::forge();

			$db->table('migrations')->delete(['namespace' => 'App\Modules\Colors']);

			$forge->dropTable('colors_languages', TRUE);
			$forge->dropTable('colors', TRUE);

			try {
				$migrate->setNamespace('App\Modules\Colors')->latest();

				echo ' Migration for <b>Colors</b> module complete...<br />';

				echo ' Reinstall for <b>Colors</b> module complete...<br />';
			} catch (\Throwable $e) {
				echo 'Something wrong!<br />';
				echo $e;
			}
		} else {
			echo ' Reinstall for <b>Colors</b> module is disabled by the settings.<br />';
		}
	}
}