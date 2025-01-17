<?php namespace App\Modules\Pages\Config;

use CodeIgniter\Config\BaseConfig;

class Pages extends BaseConfig
{
	//to use cropping for images or not
	public $useCropImages = true;
	
	public $cropWidth = 20;
	public $cropHeight = 20;
	public $cropExportZoom = 1;
	
	//number of elements for pagination and searching
	public $elementsPerPage = 50;
}
?>