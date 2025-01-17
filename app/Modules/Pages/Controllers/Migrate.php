<?php namespace App\Modules\Pages\Controllers;

/**
 * @version 1.1.0.0
 * @author Georgi Nechovski
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

		echo ' Migration for <b>Pages</b> module start... <br />';

		try
		{
			$migrate->setNamespace('App\Modules\Pages')->latest();
			
			echo ' Migration for <b>Pages</b> module complete...<br />';
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

			echo ' Reinstall for <b>Pages</b> module start... <br />';

			$db = Database::connect();
			$forge = \Config\Database::forge();

			$db->table('migrations')->delete(['namespace' => 'App\Modules\Pages']);

			$forge->dropTable('pages_languages', TRUE);
			$forge->dropTable('pages', TRUE);

			try {
				$migrate->setNamespace('App\Modules\Pages')->latest();

				echo ' Migration for <b>Pages</b> module complete...<br />';

				echo ' Reinstall for <b>Pages</b> module complete...<br />';
			} catch (\Throwable $e) {
				echo 'Something wrong!<br />';
				echo $e;
			}
		} else {
			echo ' Reinstall for <b>Pages</b> module is disabled by the settings.<br />';
		}
	}
}