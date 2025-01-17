<?php
/**
 * @package Settings
 * @author Georgi Nechovski
 * @copyright 2022 Dunav Soft Ltd
 * @version 1.0.0.0
 */

namespace App\Modules\Settings\Controllers;

class AdminSettingsController extends BaseController
{
   protected $settingsModel;
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

		$this->useLog = false;

		if ($this->useLog) {
			$this->logModel = model('App\Modules\Settings\Models\logModel', false);
		}

		$this->settingsModel = model('App\Modules\Settings\Models\SettingsModel', false);

		$this->languagesModel = model('App\Modules\Languages\Models\LanguagesModel', false);
    }

	/**
	 * Gets list of settings, that are defined in ...
	 *
	 * @return view('template/admin')
	 */
    public function index()
	{
		helper('form');

		$data = $this->viewData;

		$data['updated_at'] = $this->settingsModel->orderBy('updated_at', 'DESC')->first();

		//$data['javascript'] = 'App\Modules\Settings\Views\form_js';

		$data['languages'] = $this->languagesModel->getActiveElements('site');

		$data['pageTitle'] = lang('AdminSettingsLang.pageTitle');
		$data['view'] = 'App\Modules\Settings\Views\admin_settings_index';

		$data['settingsFile'] = config('App\Modules\Settings\Config\Settings', false);

		$settings = $this->settingsModel->getSettings();
		foreach ($settings as $element) {
			$data['settings'][$element->setup_key . $element->locale] = $element->setup_value;
		}

		if ($this->request->getMethod() === 'post') {

			$save = $this->request->getPost('save');

			foreach ($save as $lang => $langArray) {
				foreach ($langArray as $key => $saveValue) {

					$save = [];
					$save['locale'] = $lang;
					$save['setup_key'] = $key;
					$save['setup_value'] = $saveValue;

					$this->settingsModel->saveSettings($save);
				}
			}

			$this->session->setFlashdata('message', lang('AdminSettingsLang.saved'));
			return redirect()->to('/' . $this->locale . '/admin/settings');
		}

		return view('template/admin', $data);
	}


	private function saveLog($page_id, $save, $deleteAction = false)
	{
		$saveLog = [];
		$saveLog['page_id'] = $page_id;
		$saveLog['content'] = serialize($save);
		$saveLog['user_id'] = 1; //TODO

		if ($save['id'] == false && $deleteAction == false) {
			$saveLog['action'] = 'created';
		}
		if ($save['id'] != false && $deleteAction == false) {
			$saveLog['action'] = 'edited';
		}
		if ($deleteAction === true) {
			$saveLog['action'] = 'deleted';
		}

		$this->logModel->insert($saveLog);
	}

}
