<?php

namespace App\Modules\Properties\Controllers;

use CodeIgniter\Controller;
use App\Libraries\ImagesConvert;
use App\Libraries\Slug;
use App\Modules\Routes\Models\RoutesModel;


class PropertiesCategoriesController extends BaseCategoryController
{
	protected $propertiesCategoriesModel;
	protected $propertiesCategoriesLanguagesModel;
	protected $propertiesCategoriesImagesModel;
	protected $perPage;
	protected $config;
	protected $db;

	/**
	 * Constructor.
	 */
	public function __construct()
	{
		$this->db = \Config\Database::connect();

		$this->config = new \Config\App();

		$this->propertiesCategoriesModel = new \App\Modules\Properties\Models\PropertiesCategoriesModel;
		$this->propertiesCategoriesLanguagesModel = new \App\Modules\Properties\Models\PropertiesCategoriesLanguagesModel;
		$this->propertiesCategoriesImagesModel = new \App\Modules\Properties\Models\PropertiesCategoriesImagesModel;
	}

	/**
	 * Display list of PropertiesCategories Admin Panel with pagination
	 *
	 * @param  int $page - to display page
	 * @param  string $deleted - to display deleted items
	 *
	 * @return void
	 */
	public function index(int $page = 1, string $deleted = '')
	{
		$data = $this->viewData;

		$data['deleted'] = $deleted;
		$data['page'] = $page;
		$data['lastEdidtedId'] = $this->session->getFlashdata('lastEdidtedId');
		$this->session->setFlashdata('lastEdidtedId', $data['lastEdidtedId']);

		$data['id'] = '';
		$data['uriWarningLength'] = $this->config->uriWarningLength;

		$data['isNotAjaxRequest'] = false;

		if ($deleted != false) {
			$data['pageTitle'] = lang('PropertiesCategoriesLang.moduleTitle') . lang('AdminPanel.whichDeleted');
			unset($data['useSearch']);
		} else {
			$data['pageTitle'] = lang('PropertiesCategoriesLang.moduleTitle');
		}

		$data['view'] = 'App\Modules\Properties\Views\admin\properties_categories_index';
		$data['ajax_view'] = 'App\Modules\Properties\Views\admin\properties_categories_index_ajax';

		$data['javascript'] = [
			'App\Modules\Properties\Views\admin\properties_categories_js',
			'App\Views\template\modals',
			//'App\Modules\Properties\Views\admin\modal_daterangepicker_fix_js',
		];

		$elements = $this->getPropertiesCategories($deleted, false, $page);
		$data['elements'] = $elements['elements'];
		$data['pager'] = $elements['pager'];

		if ($this->request->isAJAX()) {
			$data['is_ajax'] = true;
			return view('App\Modules\Properties\Views\admin\properties_categories_index_ajax', $data);
		}

		return view('template/admin', $data);
	}

	/**
	 * Display list of found PropertiesCategories AJAX
	 *
	 * @param  int $page - to display page
	 *
	 * @return void
	 */
	public function search(int $page = 1)
	{
		$postArray = $this->request->getPost();

		$searchText = $this->request->getPost('top-search-text');

		if ($searchText == '' && $page >= 1) {
			$searchText = $this->session->getFlashdata('searchText');
			$this->session->setFlashdata('searchText', $searchText);
		} else {
			$this->session->setFlashdata('searchText', $searchText);
		}

		//key value pairs for table field => value
		$searchArray = [
			'title' => $searchText,
		];

		$data = $this->viewData;
		$data['deleted'] = '';
		$data['page'] = $page;

		$elements = $this->searchPropertiesCategories(true, $page, 5, $searchArray);
		$data['elements'] = $elements['elements'];
		$data['pager'] = $elements['pager'];

		$data['lastEdidtedId'] = $this->session->getFlashdata('lastEdidtedId');
		$this->session->setFlashdata('lastEdidtedId', $data['lastEdidtedId']);

		return view('App\Modules\Properties\Views\admin\properties_categories_index_ajax', $data);
	}

	/**
	 * Gets all elements with default site language title
	 *
	 * @param  string $deleted - to display deleted elements or not
	 * @param  bool $activeOnly - to display ctive only elements or not.
	 * @param  int $page - pagination
	 *
	 * @return array
	 */
	public function getPropertiesCategories(string $deleted, bool $activeOnly = false, int $page = 0, $segment = 4): array
	{
		$returnArray = [];

		if ($deleted == 'deleted') {
			$_elements = $this->propertiesCategoriesModel->getDeletedElements();
		} else {
			$_elements = $this->propertiesCategoriesModel->getElements($deleted, $activeOnly)->paginate($this->viewData['config']->elementsPerPage, 'group', $page, $segment);
		}

		$_pager = $this->propertiesCategoriesModel->pager;

		foreach ($_elements as &$element) {
			$element->title = $this->_getDefaultTitle($element->id);
		}

		$returnArray['elements'] = $_elements;
		$returnArray['pager'] = $_pager;

		return $returnArray;
	}

	/**
	 * Search overd elements with default site language title
	 *
	 * @param  bool $activeOnly - to display ctive only elements or not.
	 * @param  int $page - pagination
	 * @param  int $segment - segment
	 * @param  array $searchArray 
	 *
	 * @return array
	 */
	public function searchPropertiesCategories(bool $activeOnly = false, int $page = 0, int $segment = 4, $searchArray = []): array
	{
		$_elements = $this->propertiesCategoriesLanguagesModel->searchPropertiesCategoriesLanguagesByDefaultSiteLanguage($activeOnly, $searchArray)->paginate($this->viewData['config']->elementsPerPage, 'group', $page, $segment);

		$_pager = $this->propertiesCategoriesLanguagesModel->pager;

		foreach ($_elements as &$element) {
			$element->title = $this->_getDefaultTitle($element->id);
		}

		$returnArray['elements'] = $_elements;
		$returnArray['pager'] = $_pager;

		return $returnArray;
	}

	/**
	 * Gets the default site language title
	 *
	 * @param  int $id - propertiesCategory id
	 *
	 * @return string
	 */
	private function _getDefaultTitle(int $id): string
	{
		$element = $this->propertiesCategoriesLanguagesModel->getPropertyLangRowByDefaultSiteLanguage($id);
		if ($element == null) {
			return '';
		}

		return $element->title;
	}

	/**
	 * Gets the element data to edit in a form
	 *
	 * @param  mixed $id - propertiesCategory id
	 * @param  mixed $duplicate - to copy element or not.
	 *
	 * @return mixed
	 */
	public function form($id = 'new', $duplicate = false)
	{
		helper('form');

		if ($id !== 'new') {
			$data = $this->propertiesCategoriesModel->asArray()->find($id);

			$data['pageTitle'] = lang('PropertiesCategoriesLang.edit');

			if ($data == null) {
				return json_encode(['status' => 'error', 'data' => $data, 'error_message' => lang('PropertiesCategoriesLang.notFound')]);
			}
		} else {
			$data = $this->_getFieldNames();

			$data['pageTitle'] = lang('PropertiesCategoriesLang.add');
		}

		append_array_to_array($data, $this->viewData);

		$data['uriWarningLength'] = $this->config->uriWarningLength;

		$data['validationRules'] = $this->_getValidationRules();
		$data['validationRulesPrimary'] = $this->_getValidationRulesPrimary();
		$data['propertiesCategoriesImages'] = [];

		if (!$this->request->isAJAX()) {
			$data['pageTitle'] = lang('PropertiesCategoriesLang.moduleTitle');
			$data['isNotAjaxRequest'] = true;
			$data['view'] = 'App\Modules\Properties\Views\admin\properties_categories_index';
			$data['javascript'] = [
				'App\Modules\Properties\Views\admin\properties_categories_js',
				'App\Views\template\modals',
				//	'App\Modules\Properties\Views\admin\modal_daterangepicker_fix_js',
			];

			$elements = $this->getPropertiesCategories('', false, 1);
			$data['elements'] = $elements['elements'];
			$data['pager'] = $elements['pager'];

			$data['deleted'] = '';
			$data['page'] = 1;

			$data['duplicate'] = $duplicate;

			return view('template/admin', $data);
		}

		$data['isNotAjaxRequest'] = false;

		//images
		//if ($id !== 'new') {
		$data['imagesArray'] = $this->propertiesCategoriesImagesModel->getImagesByPropertiesCategoryId($id);
		// }

		$data['propertiesCategoriesLanguages'] = [];
		if ($id !== 'new') {
			$propertiesCategoriesLanguages = $this->propertiesCategoriesLanguagesModel->getPropertiesCategoriesLanguagesByPropertyId($id);
			foreach ($propertiesCategoriesLanguages as $langElement) {
				$data['propertiesCategoriesLanguages'][$langElement->lang_id] = $langElement;
			}
		}
		//to use in ImagesMultiUpl module
		$data['moduleLanguages'] = &$data['propertiesCategoriesLanguages'];

		$data['form_js'] = [
			'App\Views\template\ckeditor_js',
			'App\Modules\Common\ImageMultiUpload\Views\images_multiupload_js',
			'App\Modules\Common\ImageSingleUpload\Views\image_upload_js', //for deleting last image
		];

		$data['id'] = $id;
		if ($duplicate !== false) {
			$data['id']	= 'new';

			$data['pageTitle'] = lang('PropertiesCategoriesLang.copy');
		}

		$data['view'] = view('App\Modules\Properties\Views\admin\properties_categories_form', $data);

		return json_encode(['status' => 'success', 'data' => $data]);
	}

	private function _getValidationRules(): array
	{
		$validationRules = $this->propertiesCategoriesLanguagesModel->getValidationRules();
		$propertiesCategoriesLanguagesValidationRules = [];
		foreach ($validationRules as $key => $value) {

			$vRulesArray = explode('|', $value['rules']);

			foreach ($vRulesArray as $vRulesElement) {
				$propertiesCategoriesLanguagesValidationRules[$key . '-' . $vRulesElement] = $vRulesElement;
			}
		}

		return $propertiesCategoriesLanguagesValidationRules;
	}

	private function _getValidationRulesPrimary(): array
	{
		$validationRules = $this->propertiesCategoriesModel->getValidationRules();
		$propertiesCategoriesValidationRules = [];
		foreach ($validationRules as $key => $value) {

			$vRulesArray = explode('|', $value['rules']);

			foreach ($vRulesArray as $vRulesElement) {
				$propertiesCategoriesValidationRules[$key . '-' . $vRulesElement] = $vRulesElement;
			}
		}

		return $propertiesCategoriesValidationRules;
	}

	/**
	 * Processes the form data
	 *
	 * @param  mixed $id - propertiesCategory id
	 * 
	 * @return json
	 */
	public function form_submit($id = 'new')
	{
		if ($this->request->getMethod() === 'post') {

			// create a new Slug object
			$Slug = new Slug([
				'title' => 'title',
				'table' => 'properties_categories_languages',
				'replacement' => 'underscore',
			]);

			$formId = $id;
			$routeModel = new RoutesModel();


			// *** images *** //
			$imagesRemoveArray = [];
			if ($id !== 'new') {

				$data['imagesArray'] = $this->propertiesCategoriesImagesModel->getImagesByPropertiesCategoryId($id);

				foreach ($data['imagesArray'] as $element) {
					$element->slug = '';

					if (!empty($element->route_id)) {
						$route = $routeModel->find($element->route_id);
						$element->slug = $route->slug ?? '';
					}
					$imagesRemoveArray[$element->id] = $element->id;
				}
			}
			// *** images end *** //

			$save = $this->request->getPost('propertiesCategories');
			$saveLanguages = $this->request->getPost('properties_categories_languages');

			if ($id !== 'new') {
				$save['id'] = $id;
			} else {
				$save['id'] = false;
			}

			$this->db->transStart(); //Begin Transaction

			$lastInsertId = $this->propertiesCategoriesModel->saveElement($save);

			if ($lastInsertId != false) {

				// *** images *** // images_table_name = properties_categories_images
				$imagesPostArray = $this->request->getPost($this->viewData['images_table_name']);

				$this->_saveImages($formId, $lastInsertId, $imagesPostArray, $imagesRemoveArray);
				// *** images end *** //

				$data['id'] = $lastInsertId;

				$slugLenghtWarning = false;
				$slugOverLenghtArray = [];
				foreach ($saveLanguages as $key => $saveLang) {

					$saveLang['lang_id'] = $key;
					$saveLang['category_id'] = $lastInsertId;

					if ($saveLang['id'] == '') {
						$saveLang['id'] = false;
					}

					//images description for galleries_languages table
					$imagesDescPost = $this->request->getPost('images_desc[' . $key . ']');
					unset($imagesDescPost[0]);

					$imagesDesc = [];
					foreach ($imagesDescPost as $key => $value) {
						$imagesDesc[] = $value;
					}

					$saveLang['images_description'] = json_encode($imagesDesc);
					// end images description

					//slug 
					//$this->_createSlug($saveLang, $slugLenghtWarning, $slugOverLenghtArray);

					if (empty($saveLang['route_id'])) {
						$existingPropertiesLang = $this->propertiesCategoriesLanguagesModel
							->where('id', $saveLang['id'])
							->first();
	
						$saveLang['route_id'] = $existingPropertiesLang->route_id ?? null;
					}

					$saveLang['slug'] = $Slug->create_uri($saveLang, $saveLang['id']);

					if (strlen(site_url($saveLang['slug'])) > $this->config->uriWarningLength) {
						$slugLenghtWarning = true;
						$slugOverLenghtArray[] = site_url($saveLang['slug']);
					}

					if (empty($saveLang['route_id'])) {
						$routeData = [
							'slug' => $saveLang['slug'],
							'route' => '/properties/controllers/propertiesController::propertiesCategoriesList',
						];
						$saveLang['route_id'] = $routeModel->insert($routeData, true);
					} else {
						$routeModel->update($saveLang['route_id'], [
							'slug' => $saveLang['slug'],
							'route' =>'/properties/controllers/propertiesController::propertiesCategoriesList',
						]);
					}

					$lastInsertLanguagesId = $this->propertiesCategoriesLanguagesModel->savePropertiesCategoriesLanguages($saveLang);

					if ($lastInsertLanguagesId == false) {

						if ($id === 'new') {
							$data['id'] = 'new';
						}

						$data['error_message'] = $this->propertiesCategoriesLanguagesModel->errors();

						return json_encode(['status' => 'error', 'data' => $data]);
					}
				}

				$this->db->transComplete(); //End Transaction

				if ($this->db->transStatus() === true) {
					$data['message'] = lang('PropertiesCategoriesLang.saved', [$this->_getDefaultTitle($lastInsertId)]);

					if ($slugLenghtWarning) {
						$data['warning'] = lang('AdminPanel.slugLenghtWarning', $slugOverLenghtArray);
					}
				}

				$this->session->setFlashdata('lastEdidtedId', $lastInsertId);
			} else {

				$data['id'] = $id;

				$data['error_message'] = $this->propertiesCategoriesModel->errors();

				return json_encode(['status' => 'error', 'data' => $data]);
			}

			return json_encode(['status' => 'success', 'data' => $data]);
		}

		return json_encode(['status' => 'error', 'data' => []]);
	}

	private function _saveImages($id, $lastInsertId, $imagesPostArray, $imagesRemoveArray)
	{
		$sequence = 1;
		if ($imagesPostArray) {
			foreach ($imagesPostArray as $postElement) {

				$saveImg = [];
				$saveImg['id'] = false;
				$saveImg['category_id'] = $id;

				foreach ($postElement as $key => $value) {
					$saveImg[$key] = $value;
				}

				if ($id == 'new') {
					//COPY content of the image 
					if ($saveImg['id'] != false) {
						$originalImage = $this->propertiesCategoriesImagesModel->find($saveImg['id']);
						$saveImg['image'] = $originalImage->image;
						$saveImg['category_id'] = $lastInsertId;
					} else {
						$saveImg['id'] = false;
						$saveImg['category_id'] = $lastInsertId;
					}

					unset($imagesRemoveArray[$saveImg['id']]);
					$saveImg['id'] = false;
				}


				$saveImg['sequence'] = $sequence;

				$this->propertiesCategoriesImagesModel->save($saveImg);

				$sequence++;

				if ($saveImg['id'] != false) {
					unset($imagesRemoveArray[$saveImg['id']]);
				}
			}
		}

		//remove deleted images
		foreach ($imagesRemoveArray as $key => $value) {
			$this->propertiesCategoriesImagesModel->where('id', $key)->delete();
		}

		//save images as files
		$ImagesConvert = new ImagesConvert();
		$ImagesConvert->convertImage(['properties_categories_images'], ['properties_categories_images' => 'image'], false);
	}

	/**
	 * Validates input element from the form
	 *
	 * @return json
	 */
	public function validateField()
	{
		$fieldName = $this->request->getPost('fieldName');
		$fieldValue = $this->request->getPost('fieldValue');

		$fieldNameA = str_replace('][', '-', $fieldName);
		$fieldNameA = str_replace('[', '-', $fieldNameA);
		$fieldNameA = str_replace(']', '', $fieldNameA);

		$fieldNameA = explode('-', $fieldNameA);

		$tableName = $fieldNameA[0];

		if ($tableName == 'propertiesCategories_languages') {

			$fieldRealName = $fieldNameA[2];

			$validationRulesModel = $this->propertiesCategoriesLanguagesModel->getValidationRules();
		} elseif ($tableName == 'propertiesCategories') {

			$fieldRealName = $fieldNameA[1];

			$validationRulesModel = $this->propertiesCategoriesModel->getValidationRules();
		} else {
			return json_encode(['status' => 'success']);
		}

		$validation = \Config\Services::validation();
		$validationRules = [];
		if (isset($validationRulesModel[$fieldRealName])) {
			$validationRules = [
				$fieldRealName => $validationRulesModel[$fieldRealName]
			];
		} else {
			return json_encode(['status' => 'success']);
		}

		$validation->setRules($validationRules);

		$post[$fieldRealName] = $fieldValue;

		if (! $validation->run($post)) {
			// handle validation errors
			$errors = $validation->getError($fieldRealName);

			return json_encode(['status' => 'error', 'errors' => $errors]);
		}

		return json_encode(['status' => 'success']);
	}

	/**
	 * Delete element
	 *
	 * @param  int $id - propertiesCategory id
	 * 
	 * @return json
	 */
	public function delete(int $id)
	{
		$locale = $this->viewData['locale'];

		if ((int)$id == 0) {
			$data['error_message'] = lang('PropertiesCategoriesLang.notFound');
			return json_encode(['status' => 'error', 'data' => $data]);
		}

		$element = $this->propertiesCategoriesModel->find($id);
		if ($element == null) {
			$data['error_message'] = lang('PropertiesCategoriesLang.notFound');
			return json_encode(['status' => 'error', 'data' => $data]);
		}

		$deleted = $this->propertiesCategoriesModel->delete($id);
		if ($deleted !== false) {

			$data['message'] = lang('PropertiesCategoriesLang.deleted', [$this->_getDefaultTitle($id)]);
			$data['id'] = $id;
			return json_encode(['status' => 'success', 'data' => $data]);
		} else {
			$data['error_message'] = $this->propertiesCategoriesModel->errors();
			return json_encode(['status' => 'error', 'data' => $data]);
		}
	}

	/**
	 * Restore element
	 *
	 * @param  int $id - propertiesCategory id
	 * 
	 * @return json
	 */
	public function restore($id)
	{
		$locale = &$this->viewData['locale'];

		if ((int)$id == 0) {
			$data['error_message'] = lang('PropertiesCategoriesLang.notFound');
			return json_encode(['status' => 'error', 'data' => $data]);
		}

		$element = $this->propertiesCategoriesModel->onlyDeleted()->find($id);
		if ($element == null) {
			$data['error_message'] = lang('PropertiesCategoriesLang.notFound');
			return json_encode(['status' => 'error', 'data' => $data]);
		}

		//TODO: check slug when restore to prevent duplicate slug


		$restored = $this->propertiesCategoriesModel->restore($id);

		if ($restored !== false) {
			$data['message'] = lang('PropertiesCategoriesLang.restored', [$this->_getDefaultTitle($id)]);
			$data['id'] = $id;
			return json_encode(['status' => 'success', 'data' => $data]);
		} else {
			$data['error_message'] = $this->propertiesCategoriesModel->errors();
			return json_encode(['status' => 'error', 'data' => $data]);
		}
	}

	/**
	 * Gets the fieldnames from database structure
	 * 
	 * @return array
	 */
	private function _getFieldNames()
	{
		$return_array = [];
		$field_data_array = $this->propertiesCategoriesModel->getFieldData();

		foreach ($field_data_array as $field) {
			$return_array[$field->name] = $field->default;
		}

		return $return_array;
	}

	/**
	 * Display list of PropertiesCategories in front
	 *
	 *
	 * @return void
	 */
	public function propertiesCategoriesList()
	{
		$data = $this->viewData;

		$data['view'] = 'App\Modules\Properties\Views\propertiesCategories_list';

		$data['javascript'] = [
			//'App\Modules\Properties\Views\admin\properties_categories_js',
		];

		$data['elements'] = $this->_getPropertiesCategoriesFront(100, 'ASC');

		return view('template/layout', $data);
	}

	/**
	 * Display list of PropertiesCategories in home page front
	 *
	 *
	 * @return void
	 */
	public function propertiesCategoriesHome()
	{
		$data = $this->viewData;

		$data['view'] = 'App\Modules\Properties\Views\propertiesCategories_list';

		$data['elements'] = $this->_getPropertiesCategoriesFront(1, 'RANDOM');

		return view('App\Modules\Properties\Views\propertiesCategories_homepage', $data);
	}

	/**
	 * Display Property in front
	 *
	 * @param  int $page - to display page
	 *
	 * @return void
	 */
	public function propertiesCategoryDetails($slug = false)
	{
		if ($slug === false) {
			throw new \CodeIgniter\Exceptions\PageNotFoundException($slug);
		}

		$locale = $this->viewData['locale'];

		$element = $this->propertiesCategoriesLanguagesModel->getPropertyBySlugAndLocale($slug, $locale);

		if ($element == null) {
			throw new \CodeIgniter\Exceptions\PageNotFoundException($slug);
		}

		$images = $this->propertiesCategoriesImagesModel->getImagesByPropertyId($element->category_id);

		$currentUrl = base_url($this->request->uri->getPath());

		$data = [
			'view' => 'App\Modules\Properties\Views\propertiesCategories_details',
			'propertiesCategory' => $element,
			'images' => $images,
			'propertiesCategorySlug' => $slug,
			'seo_url' => $currentUrl,
			'seo_title' => $element->seo_title,
			'meta' => $element->meta
		];

		append_array_to_array($data, $this->viewData);

		return view('template/layout', $data);
	}

	/**
	 * Gets all elements with default site language title
	 *
	 * @param  string $deleted - to display deleted elements or not
	 * @param  bool $activeOnly - to display ctive only elements or not.
	 * @param  int $page - pagination
	 *
	 * @return array
	 */
	private function _getPropertiesCategoriesFront($limit = 100, $order = 'DESC'): array
	{
		$locale = $this->viewData['locale'];

		$_elements = $this->propertiesCategoriesLanguagesModel->getPropertiesCategoriesLanguagesByLocale($locale, $order, $limit);

		foreach ($_elements as &$element) {
			$propertiesCategoryImage = $this->propertiesCategoriesImagesModel->getPrimaryImagesByPropertyId($element->category_id);

			$element->image = $propertiesCategoryImage->image ?? '/assets/images/no_image.png';
		}

		return $_elements;
	}
}
