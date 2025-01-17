<?php

namespace App\Modules\Languages\Controllers;

/**
 * @version 1.1.0.0
 * @author Georgi Nechovski
 * @date 2022-06-01
 */

//use App\Modules\Languages\Models\LanguagesModel;
use CodeIgniter\Controller;
use App\Filters\LoginFilter;

class LanguagesController extends BaseController
{
	protected $model;
	protected $session;
	protected $languagesModel;
	protected $lang;

	public function __construct()
	{
		$this->session = \Config\Services::session();

		$this->lang = \Config\Services::language();
		//echo '--------------------------------------------------------' . $this->lang->getLocale();

		$this->languagesModel = new \App\Modules\Languages\Models\LanguagesModel;
	}

	public function index()
	{
		helper('form');

		$data = $this->viewData;

		$data['pageTitle'] = lang('LanguagesLang.pageTitle');
		$data['view'] = 'App\Modules\Languages\Views\languages_index';
		$data['elements_admin'] = $this->languagesModel->getElements('admin');
		$data['elements_site'] = $this->languagesModel->getElements('site');

		$languagesFrontModel = new \App\Modules\Languages\Models\LanguagesFrontModel;
		$data['languagesFront'] = $languagesFrontModel->orderBy('id', 'ASC')->findAll();

		$site_active_array = $this->request->getPost('site_active');
		$site_is_default = $this->request->getPost('site_is_default');
		$site_hidden_array = $this->request->getPost('site_hidden');
		$admin_active_array = $this->request->getPost('admin_active');
		$admin_is_default = $this->request->getPost('admin_is_default');

		if ($this->request->getMethod() === 'post') {

			$languagesFront = $this->request->getPost('languages_front');

			$clear = $this->languagesModel->clearLanguageSettings();

			$inserted_site = false;
			$inserted_admin = false;
			if ($clear) {
				$inserted_site = $this->languagesModel->saveLanguage($site_active_array, $site_is_default, $site_hidden_array);
				$inserted_admin = $this->languagesModel->saveLanguage($admin_active_array, $admin_is_default);

				foreach ($languagesFront as $key => $value) {
					$save = [
						'id' => $key,
						'lang_variable' => $value['lang_variable'],
						'content' => $value['content'],
					];

					$languagesFrontModel->saveElement($save);
				}
			}

			if ($inserted_site != false && $inserted_admin != false) {

				$this->session->setFlashdata('message', lang('LanguagesLang.success'));

				return redirect()->to('/admin/languages');
			} else {
				$data['errors'] = $this->languagesModel->errors();
			}
		}

		return view('template/admin', $data);
	}

	public function languagesFilter($body)
	{
		$count = 0;

		$languagesFrontModel = new \App\Modules\Languages\Models\LanguagesFrontModel;
		$languagesFrontContent = $languagesFrontModel->findAll();

		$languagesList = $this->languagesModel->getActiveElements('site', false);
		$languagesListWithoutSelected = $this->languagesModel->getActiveElements('site', false, $this->lang->getLocale());

		$parser = \Config\Services::parser();

		foreach ($languagesFrontContent as $element) {

			$languagesArray = [];
			$languagesArray['locale'] = $this->lang->getLocale();
			$languagesArray['total'] = count($languagesList);

			$i = 0;
			$selected = '';
			foreach ($languagesList as $langElement) {
				$active = '';

				if ($langElement->uri == $languagesArray['locale']) {
					$active = 'active';
					$selected = $langElement->native_name;
				}

				$languagesArray['languages'][] = [
					'title' => $langElement->native_name,
					'code' => $langElement->code,
					'link' => site_url($langElement->uri),
					'active' => $active,
					'i' => $i,
				];

				$i++;
			}

			$i = 0;
			$selected = '';
			foreach ($languagesListWithoutSelected as $langElement) {
				$active = '';

				if ($langElement->uri == $languagesArray['locale']) {
					$active = 'active';
					$selected = $langElement->native_name;
				}

				$languagesArray['languages_without_selected'][] = [
					'title' => $langElement->native_name,
					'code' => $langElement->code,
					'link' => site_url($langElement->uri),
					'active' => $active,
					'i' => $i,
				];

				$i++;
			}

			$languagesArray['selected'] = $selected;

			$parsedString = $parser->setData($languagesArray)->renderString($element->content);

			$body = str_replace('{{' . $element->lang_variable . '}}', $parsedString, $body, $count);
		}

		// Use the new body and return the updated Response
		return $body;
	}
}
