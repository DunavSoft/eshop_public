<?php
namespace App\Modules\Colors\Controllers;

use CodeIgniter\Controller;
//use App\Libraries\Slug;
use App\Libraries\ImagesConvert;

class ColorsController extends BaseController
{
   protected $colorsModel;
   protected $colorsLanguagesModel;
   protected $perPage;
   protected $db;
   
    /**
     * Constructor.
    */
    public function __construct()
    {
		$this->db = \Config\Database::connect();

		//$this->colorsModel = model('\App\Modules\Colors\Models\ColorsModel');
		$this->colorsModel = new \App\Modules\Colors\Models\ColorsModel;
		$this->colorsLanguagesModel = new \App\Modules\Colors\Models\ColorsLanguagesModel;
    }
	
	/**
	 * Display list of Colors Admin Panel with pagination
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
		
		$data['isNotAjaxRequest'] = false;

		if($deleted != false) {
			$data['pageTitle'] = lang('ColorsLang.moduleTitle') . lang('AdminPanel.whichDeleted');
			unset($data['useSearch']);
		} else {
			$data['pageTitle'] = lang('ColorsLang.moduleTitle');
		}

		$data['view'] = 'App\Modules\Colors\Views\admin\colors_index';
		$data['ajax_view'] = 'App\Modules\Colors\Views\admin\colors_index_ajax';

		$data['javascript'] = [
			'App\Modules\Colors\Views\admin\colors_js',
			'App\Views\template\modals',
		];
		
		$elements = $this->getColors($deleted, false, $page);
		$data['elements'] = $elements['elements'];
		$data['pager'] = $elements['pager'];
		
		if ($this->request->isAJAX()) {
			$data['is_ajax'] = true;
			return view('App\Modules\Colors\Views\admin\colors_index_ajax', $data);
		}
		
		return view('template/admin', $data);
	}
	
	/**
	 * Display list of found Colors AJAX
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

		$elements = $this->searchColors(true, $page, 5, $searchArray);
		$data['elements'] = $elements['elements'];
		$data['pager'] = $elements['pager'];
		
		$data['lastEdidtedId'] = $this->session->getFlashdata('lastEdidtedId');
		$this->session->setFlashdata('lastEdidtedId', $data['lastEdidtedId']);
		
		return view('App\Modules\Colors\Views\admin\colors_index_ajax', $data);
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
	public function getColors(string $deleted, bool $activeOnly = false, int $page = 0, $segment = 4) : array
	{
		$returnArray = [];
		
		if ($deleted == 'deleted') {
			$_elements = $this->colorsModel->getDeletedElements();
		} else {
			$_elements = $this->colorsModel->getElements($deleted, $activeOnly)->paginate($this->viewData['config']->elementsPerPage, 'group', $page, $segment);
		}
		
		$_pager = $this->colorsModel->pager;

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
	public function searchColors(bool $activeOnly = false, int $page = 0, int $segment = 4, $searchArray = []) : array
	{
		$_elements = $this->colorsLanguagesModel->searchColorsLanguagesByDefaultSiteLanguage($activeOnly, $searchArray)->paginate($this->viewData['config']->elementsPerPage, 'group', $page, $segment);

		$_pager = $this->colorsLanguagesModel->pager;

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
	 * @param  int $id - color id
	 *
	 * @return string
	 */
	private function _getDefaultTitle(int $id) : string
	{
		$element = $this->colorsLanguagesModel->getColorLangRowByDefaultSiteLanguage($id);
		if ($element == null) {
			return '';
		}

		return $element->title;
	}
	
	/**
	 * Gets the element data to edit in a form
	 *
	 * @param  mixed $id - color id
	 * @param  mixed $duplicate - to copy element or not.
	 *
	 * @return mixed
	 */
	public function form($id = 'new', $duplicate = false)
	{
		helper('form');
		
		if ($id !== 'new') {
			$data = $this->colorsModel->asArray()->find($id);
			
			$data['pageTitle'] = lang('ColorsLang.edit');
			
			if ($data == null) {
				return json_encode(['status' => 'error', 'data' => $data, 'error_message' => lang('ColorsLang.notFound')]);
			}
		} else {
			$data = $this->_getFieldNames();

			$data['pageTitle'] = lang('ColorsLang.add');
		}
		
		append_array_to_array($data, $this->viewData);
		
		$data['validationRules'] = $this->_getValidationRules();
		//$data['colorsImages'] = [];
		
		if (!$this->request->isAJAX()) {
			$data['pageTitle'] = lang('ColorsLang.moduleTitle');
			$data['isNotAjaxRequest'] = true;
			$data['view'] = 'App\Modules\Colors\Views\admin\colors_index';
			$data['javascript'] = [
				'App\Modules\Colors\Views\admin\colors_js',
				'App\Views\template\modals',
			];
			
			$elements = $this->getColors('', false, 1);
			$data['elements'] = $elements['elements'];
			$data['pager'] = $elements['pager'];
			
			$data['deleted'] = '';
			$data['page'] = 1;

			$data['duplicate'] = $duplicate;
			
			return view('template/admin', $data);
		}
		
		$data['isNotAjaxRequest'] = false;
		//$data['pageTitle'] = lang('ColorsLang.edit');
		
		$data['colorsLanguages'] = [];
		if ($id !== 'new') {
			$colorsLanguages = $this->colorsLanguagesModel->getColorsLanguagesByColorId($id);
			foreach ($colorsLanguages as $langElement) {
				$data['colorsLanguages'][$langElement->lang_id] = $langElement;
			}
		}
		//to use in ImagesMultiUpl module
		$data['moduleLanguages'] = &$data['colorsLanguages'];
		$data['imagesArray'][] = $data['image'];
		
		$data['form_js'] = [
			'App\Modules\Common\Views\images_multiupload\images_multiupload_js',
			'App\Modules\Common\Views\image_upload\image_upload_js',
		];

		$data['id'] = $id;
		if ($duplicate !== false) {
			$data['id']	= 'new';

			$data['pageTitle'] = lang('ColorsLang.copy');
		}
		
		$data['view'] = view('App\Modules\Colors\Views\admin\colors_form', $data);
		
		return json_encode(['status' => 'success', 'data' => $data]);
	}
	
	private function _getValidationRules() : array
	{
		$validationRules = $this->colorsLanguagesModel->getValidationRules();
		$colorsLanguagesValidationRules = [];
		foreach ($validationRules as $key => $value) {
			//d($key);
			$vRulesArray = explode('|', $value['rules']);
			//d($vRulesArray);
			foreach ($vRulesArray as $vRulesElement) {
				$colorsLanguagesValidationRules[$key . '-' . $vRulesElement] = $vRulesElement;
			}
		}
		
		return $colorsLanguagesValidationRules;
	}
	
	/**
	 * Processes the form data
	 *
	 * @param  mixed $id - color id
	 * 
	 * @return json
	 */
	public function form_submit($id = 'new')
	{
		if ($this->request->getMethod() === 'post') {
			
			$formId = $id;
			
			// *** image *** //
			/*
			$imagesRemoveArray = [];
			if ($id !== 'new') {
				
				$data['imagesArray'] = $this->colorsImagesModel->getImagesByColorId($id);
				
				foreach ($data['imagesArray'] as $element)  {
					$imagesRemoveArray[$element->id] = $element->id;
				}
			}
			*/
			// *** image end *** //

			$save = $this->request->getPost('save');
			$saveLanguages = $this->request->getPost('colors_languages');

			if ($id !== 'new') {
				$save['id'] = $id;
			} else {
				$save['id'] = false;
			}

			$this->db->transStart(); //Begin Transaction

			//because active and sequence are disabled in the form!!!
			$save['image'] = '';

			$lastInsertId = $this->colorsModel->saveElement($save);

			if ($lastInsertId != false) {
				
				// *** image *** // images_table_name = colors_images
				$imagesPostArray = $this->request->getPost($this->viewData['images_table_name']);
				
				$this->_saveImage($formId, $lastInsertId, $imagesPostArray);
				// *** image end *** //
				
				$data['id'] = $lastInsertId;

				foreach ($saveLanguages as $key => $saveLang) {
					
					$saveLang['lang_id'] = $key;
					$saveLang['color_id'] = $lastInsertId;

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

					$lastInsertLanguagesId = $this->colorsLanguagesModel->saveColorsLanguages($saveLang);

					if ($lastInsertLanguagesId == false) {

						if ($id === 'new') {
                            $data['id'] = 'new';
                        }

						$data['error_message'] = $this->colorsLanguagesModel->errors();
						
						return json_encode(['status' => 'error', 'data' => $data]);
					}
				}

				$this->db->transComplete(); //End Transaction

                if ($this->db->transStatus() === true) {
					$data['message'] = lang('ColorsLang.saved', [$this->_getDefaultTitle($lastInsertId)]);
				}
				
				$this->session->setFlashdata('lastEdidtedId', $lastInsertId);
				
			} else {

				$data['id'] = $id;

				$data['error_message'] = $this->colorsModel->errors();

				return json_encode(['status' => 'error', 'data' => $data]);
			}
			
			return json_encode(['status' => 'success', 'data' => $data]);
		}
		
		return json_encode(['status' => 'error', 'data' => []]);
	}
	
	private function _saveImage($id, $lastInsertId, $imagesPostArray) 
	{
		if ($imagesPostArray) {
			foreach ($imagesPostArray as $postElement) {
			
				$saveImg = [];
				$saveImg['id'] = $id;
				$saveImg['image'] = $postElement['image'];
				//var_dump($saveImg);
				//var_dump($postElement);exit;
				
				if ($id == 'new') {
					/*
					//COPY content of the image 
					if ($saveImg['id'] != false) {
						$originalImage = $this->colorsImagesModel->find($saveImg['id']);
						$saveImg['image'] = $originalImage->image;
						$saveImg['color_id'] = $lastInsertId;
					}
					
					unset($imagesRemoveArray[$saveImg['id']]);
					$saveImg['id'] = false;
					*/
					
					$saveImg['id'] = $lastInsertId;
					
				}
				$this->colorsModel->save($saveImg);
				
				if ($saveImg['id'] != false) {
					//unset($imagesRemoveArray[$saveImg['id']]);
				}
			}
		}
	
		//save image as file
		$ImagesConvert = new ImagesConvert();
		$ImagesConvert->convertImage(['colors'], ['colors' => 'image']);
	}
	
	/**
	 * Delete element
	 *
	 * @param  int $id - color id
	 * 
	 * @return json
	 */
	public function delete(int $id)
	{
		$locale = $this->viewData['locale'];

		if ((int)$id == 0) {
			$data['error_message'] = lang('ColorsLang.notFound');
			return json_encode(['status' => 'error', 'data' => $data]);
		}

		$element = $this->colorsModel->find($id);
		if ($element == null) {
			$data['error_message'] = lang('ColorsLang.notFound');
			return json_encode(['status' => 'error', 'data' => $data]);
		}

		$deleted = $this->colorsModel->delete($id);
		if ($deleted !== false) {

			$data['message'] = lang('ColorsLang.deleted', [$this->_getDefaultTitle($id)]);
			$data['id'] = $id;
			return json_encode(['status' => 'success', 'data' => $data]);

		} else {
			$data['error_message'] = $this->colorsModel->errors();
			return json_encode(['status' => 'error', 'data' => $data]);
		}
	}
	
	/**
	 * Restore element
	 *
	 * @param  int $id - color id
	 * 
	 * @return json
	 */
	public function restore($id)
	{
		$locale = &$this->viewData['locale'];

		if ((int)$id == 0) {
			$data['error_message'] = lang('ColorsLang.notFound');
			return json_encode(['status' => 'error', 'data' => $data]);
		}

		$element = $this->colorsModel->onlyDeleted()->find($id);
		if ($element == null) {
			$data['error_message'] = lang('ColorsLang.notFound');
			return json_encode(['status' => 'error', 'data' => $data]);
		}

		$restored = $this->colorsModel->restore($id);

		if ($restored !== false) {
			$data['message'] = lang('ColorsLang.restored', [$this->_getDefaultTitle($id)]);
			$data['id'] = $id;
			return json_encode(['status' => 'success', 'data' => $data]);
		} else {
			$data['error_message'] = $this->colorsModel->errors();
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
		$field_data_array = $this->colorsModel->getFieldData();

		foreach ($field_data_array as $field) {
			$return_array[$field->name] = $field->default;
		}

		return $return_array;
	}
	
	
	/*
	public function ordering($id)
	{
		$data = $this->viewData;

		$locale = service('request')->getLocale();

		$productsLanguagesModel = new \App\Modules\Products\Models\ProductsLanguagesModel;
		$products = $productsLanguagesModel->getProductsByCategoryLang($id, $locale, true);

		$category = $this->distributorsLanguagesModel->getCategoryById($id, $locale, false);
		
		$title = $category->title ?? '';
		$data['pageTitle'] = lang('DistributorsLang.ordering') . $title;
		$data['view'] = 'App\Modules\Distributors\Views\admin_distributors_ordering';
		$data['products'] = $products;
		$data['category_id'] = $id;
		$data['javascript'] = 'App\Modules\Distributors\Views\ordering_js';
		$data['are_you_sure'] = 'App\Views\template\are_you_sure';

		return view('template/admin', $data);
	}
*/
}