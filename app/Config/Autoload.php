<?php

namespace Config;

use CodeIgniter\Config\AutoloadConfig;

/**
 * -------------------------------------------------------------------
 * AUTO-LOADER
 * -------------------------------------------------------------------
 *
 * This file defines the namespaces and class maps so the Autoloader
 * can find the files as needed.
 *
 * NOTE: If you use an identical key in $psr4 or $classmap, then
 * the values in this file will overwrite the framework's values.
 */
class Autoload extends AutoloadConfig
{
	/**
	 * -------------------------------------------------------------------
	 * Namespaces
	 * -------------------------------------------------------------------
	 * This maps the locations of any namespaces in your application to
	 * their location on the file system. These are used by the autoloader
	 * to locate files the first time they have been instantiated.
	 *
	 * The '/app' and '/system' directories are already mapped for you.
	 * you may change the name of the 'App' namespace if you wish,
	 * but this should be done prior to creating any namespaced classes,
	 * else you will need to modify all of those classes for this to work.
	 *
	 * Prototype:
	 *
	 *   $psr4 = [
	 *       'CodeIgniter' => SYSTEMPATH,
	 *       'App'	       => APPPATH
	 *   ];
	 *
	 * @var array<string, string>
	 */

	 public $psr4 = [
		APP_NAMESPACE => APPPATH, // For custom app namespace
		'Config'      => APPPATH . 'Config',
		/*	'App\Modules\Pages' => APPPATH . 'Modules' . DIRECTORY_SEPARATOR . 'Pages',
			'App\Modules\Categories' => APPPATH . 'Modules' . DIRECTORY_SEPARATOR . 'Categories',
			'App\Modules\Products' => APPPATH . 'Modules' . DIRECTORY_SEPARATOR . 'Products',
			//'App\Modules\Sitemap' => APPPATH . 'Modules' . DIRECTORY_SEPARATOR . 'Sitemap',
			//'App\Modules\Manual' => APPPATH . 'Modules' . DIRECTORY_SEPARATOR . 'Manual',
			'App\Modules\Languages' => APPPATH . 'Modules' . DIRECTORY_SEPARATOR . 'Languages',
			'App\Modules\Admin' => APPPATH . 'Modules' . DIRECTORY_SEPARATOR . 'Admin',
			'App\Modules\Menus' => APPPATH . 'Modules' . DIRECTORY_SEPARATOR . 'Menus',
			'App\Modules\Settings' => APPPATH . 'Modules' . DIRECTORY_SEPARATOR . 'Settings',
			'App\Modules\Smap' => APPPATH . 'Modules' . DIRECTORY_SEPARATOR . 'Smap',
			'App\Modules\Questions' => APPPATH . 'Modules' . DIRECTORY_SEPARATOR . 'Questions',
			'App\Modules\Land' => APPPATH . 'Modules' . DIRECTORY_SEPARATOR . 'Land',
			'App\Modules\Galleries' => APPPATH . 'Modules' . DIRECTORY_SEPARATOR . 'Galleries',
			*/
	];

	/**
	 * -------------------------------------------------------------------
	 * Class Map
	 * -------------------------------------------------------------------
	 * The class map provides a map of class names and their exact
	 * location on the drive. Classes loaded in this manner will have
	 * slightly faster performance because they will not have to be
	 * searched for within one or more directories as they would if they
	 * were being autoloaded through a namespace.
	 *
	 * Prototype:
	 *
	 *   $classmap = [
	 *       'MyClass'   => '/path/to/class/file.php'
	 *   ];
	 *
	 * @var array<string, string>
	 */
	public $classmap = [];

	

	public function __construct()
	{
		parent::__construct();

		$dir = $this->directory_map(APPPATH . 'Modules', 1);
		foreach ($dir as $fileinfo) {
			$this->psr4['App\Modules\\' . $fileinfo] = APPPATH . 'Modules' . DIRECTORY_SEPARATOR . $fileinfo;
		}

		foreach ($dir as $fileinfo) {
			$classmap[$fileinfo . 'Controller'] = APPPATH . 'Modules' . DIRECTORY_SEPARATOR . $fileinfo . DIRECTORY_SEPARATOR . 'Controllers' . DIRECTORY_SEPARATOR . $fileinfo . 'Controller.php';
		}
	}


	private function directory_map(string $source_dir, int $directory_depth = 0, bool $hidden = false): array
	{
		try
		{
			$fp = opendir($source_dir);

			$fileData   = [];
			$new_depth  = $directory_depth - 1;
			$source_dir = rtrim($source_dir, DIRECTORY_SEPARATOR) . DIRECTORY_SEPARATOR;

			while (false !== ($file = readdir($fp)))
			{
				// Remove '.', '..', and hidden files [optional]
				if ($file === '.' || $file === '..' || ($hidden === false && $file[0] === '.'))
				{
					continue;
				}

				if (($directory_depth < 1 || $new_depth > 0) && is_dir($source_dir . $file))
				{
					$fileData[$file] = directory_map($source_dir . $file, $new_depth, $hidden);
				}
				else
				{
					$fileData[] = $file;
				}
			}

			closedir($fp);
			return $fileData;
		}
		catch (\Throwable $e)
		{
			return [];
		}
	}
}
