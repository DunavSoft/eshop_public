<?php namespace App\Config;

use CodeIgniter\Config\BaseConfig;

class Properties extends BaseConfig
{
	//to use cropping for images or not
	public $useCropImages = false;
	
	public $cropWidth = 300;
	public $cropHeight = 180;
	public $cropExportZoom = 5;
	
	//number of elements for pagination and searching
	public $elementsPerPage = 30;
	
	//show Description form in Admin panel
	public $useDescription = true;
}
?>