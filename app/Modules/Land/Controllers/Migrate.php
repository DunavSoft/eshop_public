<?php namespace App\Modules\Land\Controllers;

class Migrate extends BaseController
{
	public function index()
	{
		$migrate = \Config\Services::migrations();

		try
		{
			$migrate->latest();
			echo 'OK';
		}
		catch (\Throwable $e)
		{
			echo $e;
				// Do something with the error here...
		}
	}
}