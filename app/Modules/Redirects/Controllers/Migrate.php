<?php namespace App\Modules\Redirects\Controllers;

/**
 * @version 1.0.0.0
 * @author Georgi Nechovski
 * @edited on 2023-03-19
 */
 
use CodeIgniter\Controller;
use Throwable;

class Migrate extends BaseController
{
	
	public function index() 
	{
		$migrate = \Config\Services::migrations();

		echo ' Migration for <b>Redirects</b> module start... <br />';

		try
		{
			$migrate->setNamespace('App\Modules\Redirects')->latest();
			
			echo ' Migration for <b>Redirects</b> module complete...<br />';
			
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

		echo ' Regress Migration for <b>Redirects</b> module start... <br />';

		try
		{
			$migrate->setNamespace('App\Modules\Redirects')->regress($nrSteps, 'default');
			
			echo ' Regress Migration for <b>Redirects</b> module complete...<br />';
		}
		catch (\Throwable $e)
		{
			echo 'Something wrong!<br />';
			echo $e;
		}
	}
}