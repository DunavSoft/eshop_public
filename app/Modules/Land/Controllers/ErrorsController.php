<?php 
/**
 * @package Land
 * @version 1.0.0.5
 * @version date 2022-07-01
 * @author Georgi Nechovski
 */
 
namespace App\Modules\Land\Controllers;

use CodeIgniter\Controller;

class ErrorsController extends BaseController
{
	public function show404()
	{
		$data = ['view' => 'App\Modules\Pages\Views\pages_view'];
		
		helper('array_helper');
		append_array_to_array($data, $this->viewData);
		
		$settingsModel = new \App\Modules\Settings\Models\SettingsModel;
        $locale = service('request')->getLocale();
		
		$uri = service('uri');
		$langSegment = $uri->getSegment(1);
		
		$config = new \Config\App();
		
		if ($locale != $langSegment && in_array($langSegment, $config->supportedLocales)) {
			service('request')->setLocale('en');
			$locale = $langSegment;
		}
		/*
        $settings = $settingsModel->getSettingsByLocale($locale);
        foreach ($settings as $element) {
            $data['settings'][$element->setup_key] = $element->setup_value;
        }*/

		$body = view('template/layout', $data);
		
		$body = $this->_languagesFilter($body);
		
		$body = $this->_categoriesFilter($body);
		
		$body = $this->_settingsFilter($body, $locale);

		$body = $this->_categoryMenuFilter($body);

		$body = $this->_menusFilter($body);

		echo $body;
	}

	private function _languagesFilter($body)
	{
		$languagesController = new \App\Modules\Languages\Controllers\LanguagesController;
		
		$body = $languagesController->languagesFilter($body);
		
		return $body;
	}
  
	private function _categoriesFilter($body)
	{
		//$languagesController = new \App\Modules\Languages\Controllers\LanguagesController;
		
		//$body = $languagesController->languagesFilter($body);
    
    $categoriesController = new \App\Modules\Products\Controllers\ProductsCategoriesController;
    
    $body = $categoriesController->categoryFilter($body);
		
		return $body;
	}
	
	private function _settingsFilter($body, $locale)
	{
		$count = 0;
		
		//$body = $response->getBody();
		//$locale = service('request')->getLocale();
		
		$settingsModel = new \App\Modules\Settings\Models\SettingsModel;
		
		$settingsArray = [];
		$settings = $settingsModel->getSettingsByLocale($locale);
		foreach ($settings as $element) {
			$settingsArray[$element->setup_key] = $element->setup_value;
			$body = str_replace('{' . $element->setup_key . '}', $element->setup_value, $body, $count);
		}

		// Use the new body and return the updated Response
		return $body;
	}
	
	private function _menusFilter($body)
	{
		$menusController = new \App\Modules\Menus\Controllers\MenusController;
		
		$body = $menusController->menusFilter($body);
		
		return $body;
	}

	private function _categoryMenuFilter($body)
	{
		$cart = new \App\Modules\Cart\Libraries\Cart;

		$body = str_replace('{{cart_total_items}}', $cart->getTotalItems(), $body);
		
		return $body;
	}

	
	//--------------------------------------------------------------------
}
