<?php namespace App\Config;

use CodeIgniter\Config\BaseConfig;

class PropertiesCategories extends BaseConfig
{
	//to use cropping for images or not
	public $useCropImages = true;
	
	public $cropWidth = 200;
	public $cropHeight = 150;
	public $cropExportZoom = 1;
	
	//number of elements for pagination and searching
	public $elementsPerPage = 30;
	
	//show Description form in Admin panel
	public $useDescription = false;
}
?>