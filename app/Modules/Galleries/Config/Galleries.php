<?php namespace App\Config;

use CodeIgniter\Config\BaseConfig;

class Products extends BaseConfig
{
	//to use cropping for images or not
	public $useCropImages = true;
	
	public $cropWidth = 200;
	public $cropHeight = 120;
	public $cropExportZoom = 5;
}
?>