<?php

/**
 * @package ShopSettings
 * @author Georgi Nechovski
 * @copyright 2022 Dunav Soft Ltd
 * @version 1.0.0.0
 */

namespace App\Modules\ShopSettings\Controllers;

class ShopSettingsController extends BaseController
{
	protected $shopsettingsModel;
	protected $session;
	protected $useLog;
	protected $logModel;
	protected $locale;


	/**
	 * Constructor.
	 */
	public function __construct()
	{
		$this->session = \Config\Services::session();

		//$this->config = new \Config\App();

		//$this->lang = \Config\Services::language();

		$this->locale = service('request')->getLocale();

		$this->shopsettingsModel = model('App\Modules\ShopSettings\Models\ShopSettingsModel', false);

		$this->languagesModel = model('App\Modules\Languages\Models\LanguagesModel', false);

		
	}

	/**
	 * Gets list of shopsettings, that are defined in ...
	 *
	 * @return view('template/admin')
	 */
	public function index()
	{
		helper('form');

		$data = $this->viewData;

		$data['updated_at'] = $this->shopsettingsModel->orderBy('updated_at', 'DESC')->first();

		//$data['javascript'] = 'App\Modules\ShopSettings\Views\form_js';

		$data['languages'] = $this->languagesModel->getActiveElements('site');

		$data['pageTitle'] = lang('ShopSettingsLang.moduleTitle');
		$data['view'] = 'App\Modules\ShopSettings\Views\shopsettings_index';

		$data['shopsettingsFile'] = config('App\Modules\ShopSettings\Config\ShopSettings', false);
		$data['shippingConfig'] = config('\App\Modules\Shipping\Config\Shipping');

		$shopsettings = $this->shopsettingsModel->getShopSettings();
		foreach ($shopsettings as $element) {
			$data['shopsettings'][$element->setup_key . $element->locale] = $element->setup_value;
		}

		if ($this->request->getMethod() === 'post') {

			$save = $this->request->getPost('save');

			foreach ($save as $lang => $langArray) {
				foreach ($langArray as $key => $saveValue) {

					$save = [];
					$save['locale'] = $lang;
					$save['setup_key'] = $key;
					$save['setup_value'] = $saveValue;

					$this->shopsettingsModel->saveShopSettings($save);
				}
			}

			$this->session->setFlashdata('message', lang('ShopSettingsLang.saved'));
			return redirect()->to('/' . $this->locale . '/admin/shopsettings');
		}

		return view('template/admin', $data);
	}
}
