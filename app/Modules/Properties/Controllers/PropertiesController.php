<?php
namespace App\Modules\Properties\Controllers;

use CodeIgniter\Controller;
use App\Libraries\Slug;
use App\Libraries\ImagesConvert;
use App\Modules\Routes\Models\RoutesModel;


class PropertiesController extends BaseController
{
   protected $propertiesModel;
   protected $propertiesLanguagesModel;
   protected $propertiesImagesModel;
   protected $propertiesCategoriesLanguagesModel;
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
		
		$this->propertiesModel = new \App\Modules\Properties\Models\PropertiesModel;
		$this->propertiesLanguagesModel = new \App\Modules\Properties\Models\PropertiesLanguagesModel;
		$this->propertiesImagesModel = new \App\Modules\Properties\Models\PropertiesImagesModel;
		
		$this->propertiesCategoriesLanguagesModel = new \App\Modules\Properties\Models\PropertiesCategoriesLanguagesModel;
    }
	
	/**
	 * Display list of Properties Admin Panel with pagination
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
            $data['pageTitle'] = lang('PropertiesLang.moduleTitle') . lang('AdminPanel.whichDeleted');
            unset($data['useSearch']);
        } else {
            $data['pageTitle'] = lang('PropertiesLang.moduleTitle');
        }
		
		$data['view'] = 'App\Modules\Properties\Views\admin\properties_index';
		$data['ajax_view'] = 'App\Modules\Properties\Views\admin\properties_index_ajax';

		$data['javascript'] = [
			'App\Modules\Properties\Views\admin\properties_js',
			'App\Views\template\modals',
		];
		
		$categories = $this->propertiesCategoriesLanguagesModel->getPropertiesCategoriesLanguagesByLocale($data['locale'], 'ASC', false);
		foreach ($categories as $category) {
			$data['categories'][$category->id] = $category->title;
		}
		
		$elements = $this->getProperties($deleted, false, $page);
		$data['elements'] = $elements['elements'];
		$data['pager'] = $elements['pager'];
		
		if ($this->request->isAJAX()) {
			$data['is_ajax'] = true;
			return view('App\Modules\Properties\Views\admin\properties_index_ajax', $data);
		}
		
		return view('template/admin', $data);
	}
	
	/**
	 * Display list of found Properties AJAX
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

		$data = $this->viewData;

		$categories = $this->propertiesCategoriesLanguagesModel->getPropertiesCategoriesLanguagesByLocale($data['locale'], 'ASC', false);
		foreach ($categories as $category) {
			$data['categories'][$category->id] = $category->title;
		}

		//key value pairs for table field => value
		$searchArray = [
			'title' => $searchText,
			//'category_id' => 10,
		];

		if (array_search($searchText, $data['categories'], false) != false) {
			$searchArray['category_id'] = array_search($searchText, $data['categories'], false);
		}
		
		$data['deleted'] = '';
		$data['page'] = $page;

		$elements = $this->searchProperties(true, $page, 5, $searchArray);
		$data['elements'] = $elements['elements'];
		$data['pager'] = $elements['pager'];
		
		$data['lastEdidtedId'] = $this->session->getFlashdata('lastEdidtedId');
		$this->session->setFlashdata('lastEdidtedId', $data['lastEdidtedId']);
		
		return view('App\Modules\Properties\Views\admin\properties_index_ajax', $data);
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
	public function getProperties(string $deleted, bool $activeOnly = false, int $page = 0, $segment = 4) : array
	{
		$returnArray = [];
		
		if ($deleted == 'deleted') {
			$_elements = $this->propertiesModel->getDeletedElements();
		} else {
			$_elements = $this->propertiesModel->getElementsWithCategories($deleted, $activeOnly)->paginate($this->viewData['config']->elementsPerPage, 'group', $page, $segment);
		}
		
		$_pager = $this->propertiesModel->pager;

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
	public function searchProperties(bool $activeOnly = false, int $page = 0, int $segment = 4, $searchArray = []) : array
	{
		$_elements = $this->propertiesLanguagesModel->searchPropertiesLanguagesByDefaultSiteLanguage($activeOnly, $searchArray)->paginate($this->viewData['config']->elementsPerPage, 'group', $page, $segment);

		$_pager = $this->propertiesLanguagesModel->pager;

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
	 * @param  int $id - property id
	 *
	 * @return string
	 */
	private function _getDefaultTitle(int $id) : string
	{
		$element = $this->propertiesLanguagesModel->getPropertyLangRowByDefaultSiteLanguage($id);
		if ($element == null) {
			return '';
		}

		return $element->title;
	}
	
	/**
	 * Gets the element data to edit in a form
	 *
	 * @param  mixed $id - property id
	 * @param  mixed $duplicate - to copy element or not.
	 *
	 * @return mixed
	 */
	public function form($id = 'new', $duplicate = false)
	{
		helper('form');
		
		if ($id !== 'new') {
			$data = $this->propertiesModel->asArray()->find($id);
			
			$data['pageTitle'] = lang('PropertiesLang.edit');
			
			if ($data == null) {
				return json_encode(['status' => 'error', 'data' => $data, 'error_message' => lang('PropertiesLang.notFound')]);
			}
		} else {
			$data = $this->_getFieldNames();

			$data['pageTitle'] = lang('PropertiesLang.add');
		}
		
		append_array_to_array($data, $this->viewData);
		
		$data['uriWarningLength'] = $this->config->uriWarningLength;
		
		$data['validationRules'] = $this->_getValidationRules();
		$data['validationRulesPrimary'] = $this->_getValidationRulesPrimary();
		$data['propertiesImages'] = [];
		
		$data['categories'] = $this->propertiesCategoriesLanguagesModel->getPropertiesCategoriesLanguagesByLocale($data['locale'], 'ASC', false);
		
		//d($data['categories']);
		
		if (!$this->request->isAJAX()) {
			$data['pageTitle'] = lang('PropertiesLang.moduleTitle');
			$data['isNotAjaxRequest'] = true;
			$data['view'] = 'App\Modules\Properties\Views\admin\properties_index';
			$data['javascript'] = [
				'App\Modules\Properties\Views\admin\properties_js',
				'App\Views\template\modals',
			];
			
			$elements = $this->getProperties('', false, 1);
			$data['elements'] = $elements['elements'];
			$data['pager'] = $elements['pager'];
			
			//d($data['elements']);
			$data['deleted'] = '';
			$data['page'] = 1;

			$data['duplicate'] = $duplicate;
			
			return view('template/admin', $data);
		}
		
		$data['isNotAjaxRequest'] = false;
		//$data['pageTitle'] = lang('PropertiesLang.edit');

		//images
		//if ($id !== 'new') {
			$data['imagesArray'] = $this->propertiesImagesModel->getImagesByPropertyId($id);
		// }
		
		$data['propertiesLanguages'] = [];
		if ($id !== 'new') {
			$propertiesLanguages = $this->propertiesLanguagesModel->getPropertiesLanguagesByPropertyId($id);
			foreach ($propertiesLanguages as $langElement) {
				$data['propertiesLanguages'][$langElement->lang_id] = $langElement;
			}
		}
		//to use in ImagesMultiUpl module
		$data['moduleLanguages'] = &$data['propertiesLanguages'];
		
		$data['form_js'] = [
			'App\Views\template\ckeditor_js',
			'App\Modules\Common\ImageMultiUpload\Views\images_multiupload_js',
			//'App\Modules\Common\ImageMultiUpload\Views\images_multiupload_sortable_js',
			'App\Modules\Common\ImageSingleUpload\Views\image_upload_js', //for deleting last image
		];

		$data['id'] = $id;
		if ($duplicate !== false) {
			$data['id']	= 'new';

			$data['pageTitle'] = lang('PropertiesLang.copy');
		}
		
		$data['view'] = view('App\Modules\Properties\Views\admin\properties_form', $data);
		
		return json_encode(['status' => 'success', 'data' => $data]);
	}
	
	private function _getValidationRules() : array
	{
		$validationRules = $this->propertiesLanguagesModel->getValidationRules();
		$propertiesLanguagesValidationRules = [];
		foreach ($validationRules as $key => $value) {
			
			$vRulesArray = explode('|', $value['rules']);
			
			foreach ($vRulesArray as $vRulesElement) {
				$propertiesLanguagesValidationRules[$key . '-' . $vRulesElement] = $vRulesElement;
			}
		}
		
		return $propertiesLanguagesValidationRules;
	}
	
	private function _getValidationRulesPrimary() : array
	{
		$validationRules = $this->propertiesModel->getValidationRules();
		$propertiesValidationRules = [];
		foreach ($validationRules as $key => $value) {
			
			$vRulesArray = explode('|', $value['rules']);
			
			foreach ($vRulesArray as $vRulesElement) {
				$propertiesValidationRules[$key . '-' . $vRulesElement] = $vRulesElement;
			}
		}
		
		return $propertiesValidationRules;
	}
	
	/**
	 * Processes the form data
	 *
	 * @param  mixed $id - property id
	 * 
	 * @return json
	 */
	public function form_submit($id = 'new')
	{
		if ($this->request->getMethod() === 'post') {

			// create a new Slug object
			$Slug = new Slug([
				'title' => 'title',
				'table' => 'properties_languages',
			]);
			
			$formId = $id;
			$routeModel = new RoutesModel();

			// *** images *** //
			$imagesRemoveArray = [];
			if ($id !== 'new') {
				
				$data['imagesArray'] = $this->propertiesImagesModel->getImagesByPropertyId($id);
				
				foreach ($data['imagesArray'] as $element)  {
					$element->slug = '';

                if (!empty($element->route_id)) {
                    $route = $routeModel->find($element->route_id);
                    $element->slug = $route->slug ?? '';
                }
					$imagesRemoveArray[$element->id] = $element->id;
				}
			}
			// *** images end *** //

			$save = $this->request->getPost('properties');
			$saveLanguages = $this->request->getPost('properties_languages');

			if ($id !== 'new') {
				$save['id'] = $id;
			} else {
				$save['id'] = false;
			}

			$this->db->transStart(); //Begin Transaction

			$lastInsertId = $this->propertiesModel->saveElement($save);

			if ($lastInsertId != false) {
				
				// *** images *** // images_table_name = properties_images
				$imagesPostArray = $this->request->getPost($this->viewData['images_table_name']);
				
				$this->_saveImages($formId, $lastInsertId, $imagesPostArray, $imagesRemoveArray);
				// *** images end *** //
				
				$data['id'] = $lastInsertId;

				$slugLenghtWarning = false;
				$slugOverLenghtArray = [];
				foreach ($saveLanguages as $key => $saveLang) {
					
					$saveLang['lang_id'] = $key;
					$saveLang['property_id'] = $lastInsertId;

					if ($saveLang['id'] == '') {
						$saveLang['id'] = false;
					}
					
					//images description for galleries_languages table
					$imagesDescPost = $this->request->getPost('images_desc['. $key .']');
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
						$existingPropertiesLang = $this->propertiesLanguagesModel
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
							'route' => '/properties/controllers/propertiesController::propertyDetails',
						];
						$saveLang['route_id'] = $routeModel->insert($routeData, true);
					} else {
						$routeModel->update($saveLang['route_id'], [
							'slug' => $saveLang['slug'],
							'route' =>'/properties/controllers/propertiesController::propertyDetails',
						]);
					}

					$lastInsertLanguagesId = $this->propertiesLanguagesModel->savePropertiesLanguages($saveLang);

					if ($lastInsertLanguagesId == false) {

						if ($id === 'new') {
                            $data['id'] = 'new';
                        }
						
						$data['error_message'] = $this->propertiesLanguagesModel->errors();
						
						return json_encode(['status' => 'error', 'data' => $data]);
					}
				}

				$this->db->transComplete(); //End Transaction

                if ($this->db->transStatus() === true) {
					$data['message'] = lang('PropertiesLang.saved', [$this->_getDefaultTitle($lastInsertId)]);
					
					if ($slugLenghtWarning) {
						$data['warning'] = lang('AdminPanel.slugLenghtWarning', $slugOverLenghtArray);
					}
				}
				
				$this->session->setFlashdata('lastEdidtedId', $lastInsertId);
				
			} else {

				$data['id'] = $id;

				$data['error_message'] = $this->propertiesModel->errors();

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
				$saveImg['property_id'] = $id;
				
				foreach ($postElement as $key => $value) {
					$saveImg[$key] = $value;
				}
				
				if ($id == 'new') {
					//COPY content of the image 
					if ($saveImg['id'] != false) {
						$originalImage = $this->propertiesImagesModel->find($saveImg['id']);
						$saveImg['image'] = $originalImage->image;
						$saveImg['property_id'] = $lastInsertId;
					} else {
						$saveImg['id'] = false;
						$saveImg['property_id'] = $lastInsertId;
					}
					
					unset($imagesRemoveArray[$saveImg['id']]);
					$saveImg['id'] = false;
				}
				
				
				$saveImg['sequence'] = $sequence;
				
				$this->propertiesImagesModel->save($saveImg);
				
				$sequence++;
				
				if ($saveImg['id'] != false) {
					unset($imagesRemoveArray[$saveImg['id']]);
				}
			}
		}
	
		//remove deleted images
		foreach ($imagesRemoveArray as $key => $value) {
			$this->propertiesImagesModel->where('id', $key)->delete();
		}
		
		//save images as files
		$ImagesConvert = new ImagesConvert();
		$ImagesConvert->convertImage(['properties_images'], ['properties_images' => 'image'], false);
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
		
		if ($tableName == 'properties_languages') {
			
			$fieldRealName = $fieldNameA[2];
			
			$validationRulesModel = $this->propertiesLanguagesModel->getValidationRules();
			
		} elseif($tableName == 'properties') {
			
			$fieldRealName = $fieldNameA[1];
			
			$validationRulesModel = $this->propertiesModel->getValidationRules();
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
			
			return json_encode(['status' => 'error', 'errors' => $errors ]);
		}
		
		return json_encode(['status' => 'success']);
	}
	
	/**
	 * Delete element
	 *
	 * @param  int $id - property id
	 * 
	 * @return json
	 */
	public function delete(int $id)
	{
		$locale = $this->viewData['locale'];

		if ((int)$id == 0) {
			$data['error_message'] = lang('PropertiesLang.notFound');
			return json_encode(['status' => 'error', 'data' => $data]);
		}

		$element = $this->propertiesModel->find($id);
		if ($element == null) {
			$data['error_message'] = lang('PropertiesLang.notFound');
			return json_encode(['status' => 'error', 'data' => $data]);
		}

		$deleted = $this->propertiesModel->delete($id);
		if ($deleted !== false) {

			$data['message'] = lang('PropertiesLang.deleted', [$this->_getDefaultTitle($id)]);
			$data['id'] = $id;
			return json_encode(['status' => 'success', 'data' => $data]);

		} else {
			$data['error_message'] = $this->propertiesModel->errors();
			return json_encode(['status' => 'error', 'data' => $data]);
		}
	}
	
	/**
	 * Restore element
	 *
	 * @param  int $id - property id
	 * 
	 * @return json
	 */
	public function restore($id)
	{
		$locale = &$this->viewData['locale'];

		if ((int)$id == 0) {
			$data['error_message'] = lang('PropertiesLang.notFound');
			return json_encode(['status' => 'error', 'data' => $data]);
		}

		$element = $this->propertiesModel->onlyDeleted()->find($id);
		if ($element == null) {
			$data['error_message'] = lang('PropertiesLang.notFound');
			return json_encode(['status' => 'error', 'data' => $data]);
		}
		
		

		$restored = $this->propertiesModel->restore($id);

		if ($restored !== false) {
			$data['message'] = lang('PropertiesLang.restored', [$this->_getDefaultTitle($id)]);
			$data['id'] = $id;
			return json_encode(['status' => 'success', 'data' => $data]);
		} else {
			$data['error_message'] = $this->propertiesModel->errors();
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
		$field_data_array = $this->propertiesModel->getFieldData();

		foreach ($field_data_array as $field) {
			$return_array[$field->name] = $field->default;
		}

		return $return_array;
	}
	
	/**
	 * Creates the slug string
	 * 
	 */
	public function create_slug()
	{
		$inputString = $this->request->getPost('inputString');
		$id = $this->request->getPost('id');
		$lang_id = $this->request->getPost('lang_id');
		
		$_slug = new Slug_v2([
			'title' => 'title',
			'primary_table' => 'properties',
			'secondary_table' => 'properties_languages',
			'fk_field_secondary_table' => 'property_id',
		]);
		
		$saveArray['id'] = $id;
		$saveArray['title'] = $inputString;
		$saveArray['slug'] = $inputString;
		$saveArray['lang_id'] = $lang_id;

		$slug = $_slug->create_uri($saveArray, $saveArray['id']);
		
		return json_encode(['status' => 'success', 'slug' => $slug]);
	}

	/**
	 * Display list of Properties in front
	 *
	 *
	 * @return void
	 */
    public function propertiesList()
	{
		$data = $this->viewData;
		
		$data['view'] = 'App\Modules\Properties\Views\offers_list';

		$data['javascript'] = [
			//'App\Modules\Properties\Views\admin\properties_js',
		];
		
		$data['elements'] = $this->_getPropertiesFront(100, 'ASC');


		return view('template/layout', $data);
	}
	
	/**
	 * Display list of Properties in home page front
	 *
	 *
	 * @return void
	 */
    public function propertiesHome()
	{
		$data = $this->viewData;
		
		$data['view'] = 'App\Modules\Properties\Views\offers_list';

		$data['elements'] = $this->_getPropertiesFront(1, 'RANDOM');
		
		return view('App\Modules\Properties\Views\offers_homepage', $data);
	}
	
	/**
	 * Display Property in front
	 *
	 * @param  int $page - to display page
	 *
	 * @return void
	 */
    public function propertyDetails($slug = false)
	{
		if ($slug === false) {
			throw new \CodeIgniter\Exceptions\PageNotFoundException($slug);
		}

		$locale = $this->viewData['locale'];
		
		$element = $this->propertiesLanguagesModel->getPropertyBySlugAndLocale($slug, $locale);

		if ($element == null) {
			throw new \CodeIgniter\Exceptions\PageNotFoundException($slug);
		}
		
		$images = $this->propertiesImagesModel->getImagesByPropertyId($element->property_id);
		
		$currentUrl = base_url($this->request->uri->getPath());
		
		$data = [
			'view' => 'App\Modules\Properties\Views\offers_details',
			'property' => $element,
			'images' => $images,
			'propertySlug' => $slug,
			'seo_url' => $currentUrl,
			//'seo_title' => $element->seo_title,
			//'meta' => $element->meta
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
	private function _getPropertiesFront($limit = 100, $order = 'DESC') : array
	{
		$locale = $this->viewData['locale'];
		
		$_elements = $this->propertiesLanguagesModel->getPropertiesLanguagesByLocale($locale, $order, $limit);
		
		foreach ($_elements as &$element) {
			$propertyImage = $this->propertiesImagesModel->getPrimaryImagesByPropertyId($element->property_id);
			
			$element->image = $propertyImage->image ?? '/assets/images/no_image.png';
		}
		
		return $_elements;
	}	
}