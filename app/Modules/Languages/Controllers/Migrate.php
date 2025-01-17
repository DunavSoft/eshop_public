<?php

namespace App\Modules\Languages\Controllers;

use Config\Database;

/**
 * @version 1.0.5
 * @author Georgi Nechovski
 */

class Migrate extends BaseController
{
	private const NAMESPACE = 'App\Modules\Languages';

	private $migrate;

	public function __construct()
	{
		$this->migrate = \Config\Services::migrations();
	}

	public function index()
	{
		$migrate = \Config\Services::migrations();

		echo ' Migration for <b>Languages</b> module start... <br />';

		try {
			$migrate->setNamespace('App\Modules\Languages')->latest();

			echo ' Seed for <b>Languages</b> module start...<br />';

			$seeder = \Config\Database::seeder();
			$seeder->call('App\Modules\Languages\Database\Seeds\LanguageSeeder');

			echo ' Seed for <b>Languages</b> module complete...<br />';
			echo ' Migration for <b>Languages</b> module complete...<br />';
		} catch (\Throwable $e) {
			echo 'Something wrong!';
			echo $e;
		}
	}

	public function reinstall()
	{
		if (ENVIRONMENT !== 'development') {
			echo 'Reinstall for <b>Languages</b> module is disabled by the settings.<br />';
			return;
		}

		echo 'Reinstall for <b>Languages</b> module start... <br />';

		$db = Database::connect();
		$forge = \Config\Database::forge();

		$db->table('migrations')->delete(['namespace' => self::NAMESPACE]);
		$forge->dropTable('languages', TRUE);
		$forge->dropTable('languages_front', TRUE);

		try {
			$this->migrate->setNamespace(self::NAMESPACE)->latest();
			echo 'Migration for <b>Languages</b> module complete...<br />';

			echo ' Seed for <b>Languages</b> module start...<br />';

			$seeder = \Config\Database::seeder();
			$seeder->call('App\Modules\Languages\Database\Seeds\LanguageSeeder');

			echo ' Seed for <b>Languages</b> module complete...<br />';

			echo 'Reinstall for <b>Languages</b> module complete...<br />';
		} catch (\Throwable $e) {
			// Log the error instead of echoing it
			log_message('error', $e->getMessage());
			echo 'Something went wrong with the reinstall!<br />';
			echo $e->getMessage();
		}
	}
}
