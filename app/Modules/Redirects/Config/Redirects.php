<?php namespace App\Config;

use CodeIgniter\Config\BaseConfig;

class Brands extends BaseConfig
{
	//number of elements for pagination and searching
	public $elementsPerPage = 50;
	
	public $arrayHTTPCodes = [
		'301' => '301',
		'302' => '302',
		'303' => '303',
		'304' => '304',
		'307' => '307',
		'308' => '308',
	];
}
?>