<?php

namespace App\Modules\Redirects\Controllers;

use CodeIgniter\Controller;
//use App\Libraries\Slug;
//use App\Libraries\ImagesConvert;

class RedirectsController extends BaseController
{
	protected $redirectsModel;

	/**
	 * Constructor.
	 */
	public function __construct()
	{
		$this->redirectsModel = new \App\Modules\Redirects\Models\RedirectsModel;
	}

	/**
	 * Display list of Redirects Admin Panel with pagination
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

		if ($deleted != false) {
			$data['pageTitle'] = lang('RedirectsLang.moduleTitle') . lang('AdminPanel.whichDeleted');
			unset($data['useSearch']);
		} else {
			$data['pageTitle'] = lang('RedirectsLang.moduleTitle');
		}

		$data['view'] = 'App\Modules\Redirects\Views\admin\redirects_index';
		$data['ajax_view'] = 'App\Modules\Redirects\Views\admin\redirects_index_ajax';

		$data['javascript'] = [
			'App\Modules\Redirects\Views\admin\redirects_js',
			'App\Views\template\modals',
		];

		$elements = $this->getRedirects($deleted, false, $page);
		$data['elements'] = $elements['elements'];
		$data['pager'] = $elements['pager'];

		if ($this->request->isAJAX()) {
			$data['is_ajax'] = true;
			return view('App\Modules\Redirects\Views\admin\redirects_index_ajax', $data);
		}

		return view('template/admin', $data);
	}

	/**
	 * Display list of found Redirects AJAX
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
			'source' => $searchText,
			'target' => $searchText,
		];


		$data = $this->viewData;
		$data['deleted'] = '';
		$data['page'] = $page;

		$elements = $this->searchRedirects(true, $page, $_segment = 5, $searchArray);
		$data['elements'] = $elements['elements'];
		$data['pager'] = $elements['pager'];

		$data['lastEdidtedId'] = $this->session->getFlashdata('lastEdidtedId');
		$this->session->setFlashdata('lastEdidtedId', $data['lastEdidtedId']);

		return view('App\Modules\Redirects\Views\admin\redirects_index_ajax', $data);
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
	public function getRedirects(string $deleted, bool $activeOnly = false, int $page = 0, $segment = 4): array
	{
		$returnArray = [];

		if ($deleted == 'deleted') {
			$_elements = $this->redirectsModel->getDeletedElements();
		} else {
			$_elements = $this->redirectsModel->getElementsPaginate()->paginate($this->viewData['config']->elementsPerPage, 'group', $page, $segment);
		}

		$_pager = $this->redirectsModel->pager;

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
	public function searchRedirects(bool $activeOnly = false, int $page = 0, int $segment = 4, $searchArray = []): array
	{
		$_elements = $this->redirectsModel->searchRedirectsByArray($searchArray)->paginate($this->viewData['config']->elementsPerPage, 'group', $page, $segment);

		$_pager = $this->redirectsModel->pager;

		$returnArray['elements'] = $_elements;
		$returnArray['pager'] = $_pager;

		return $returnArray;
	}

	/**
	 * Gets the element data to edit in a form
	 *
	 * @param  mixed $id - brand id
	 * @param  mixed $duplicate - to copy element or not.
	 *
	 * @return mixed
	 */
	public function form($id = 'new', $duplicate = false)
	{
		helper('form');

		if ($id !== 'new') {
			$data = $this->redirectsModel->asArray()->find($id);

			$data['pageTitle'] = lang('RedirectsLang.edit');

			if ($data == null) {
				return json_encode(['status' => 'error', 'data' => $data, 'error_message' => lang('RedirectsLang.notFound')]);
			}
		} else {
			$data = $this->_getFieldNames();

			$data['pageTitle'] = lang('RedirectsLang.add');
		}

		append_array_to_array($data, $this->viewData);

		$data['validationRules'] = $this->_getValidationRules();
		//$data['redirectsImages'] = [];

		if (!$this->request->isAJAX()) {
			$data['pageTitle'] = lang('RedirectsLang.moduleTitle');
			$data['isNotAjaxRequest'] = true;
			$data['view'] = 'App\Modules\Redirects\Views\admin\redirects_index';
			$data['javascript'] = [
				'App\Modules\Redirects\Views\admin\redirects_js',
				'App\Views\template\modals',
			];

			$elements = $this->getRedirects('', false, 1);
			$data['elements'] = $elements['elements'];
			$data['pager'] = $elements['pager'];

			//d($data['elements']);
			$data['deleted'] = '';
			$data['page'] = 1;

			$data['duplicate'] = $duplicate;

			return view('template/admin', $data);
		}

		$data['isNotAjaxRequest'] = false;
		//$data['pageTitle'] = lang('RedirectsLang.edit'); when it's put on comment, the title of all forms shows perfectly fine


		$data['form_js'] = [
			//'App\Modules\Common\ImageMultiUpload\Views\images_multiupload_js',
			//'App\Modules\Common\ImageMultiUpload\Views\images_multiupload_sortable_js',
		];

		$data['id'] = $id;
		if ($duplicate !== false) {
			$data['id']	= 'new';

			$data['pageTitle'] = lang('RedirectsLang.copy');
		}

		$data['view'] = view('App\Modules\Redirects\Views\admin\redirects_form', $data);

		return json_encode(['status' => 'success', 'data' => $data]);
	}

	private function _getValidationRules(): array
	{
		$validationRules = $this->redirectsModel->getValidationRules();
		$redirectsValidationRules = [];
		foreach ($validationRules as $key => $value) {

			$vRulesArray = explode('|', $value);

			foreach ($vRulesArray as $vRulesElement) {
				$redirectsValidationRules[$key . '-' . $vRulesElement] = $vRulesElement;
			}
		}

		return $redirectsValidationRules;
	}

	/**
	 * Processes the form data
	 *
	 * @param  mixed $id - brand id
	 * 
	 * @return json
	 */
	public function form_submit($id = 'new')
	{
		if ($this->request->getMethod() === 'post') {

			$save = $this->request->getPost('redirects');

			if ($id !== 'new') {
				$save['id'] = $id;
			} else {
				$save['id'] = false;
			}

			$lastInsertId = $this->redirectsModel->saveElement($save);

			if ($lastInsertId != false) {

				$data['id'] = $lastInsertId;

				$data['message'] = lang('RedirectsLang.saved', ['']);

				$this->session->setFlashdata('lastEdidtedId', $lastInsertId);
			} else {
				$data['error_message'] = $this->redirectsModel->errors();

				return json_encode(['status' => 'error', 'data' => $data]);
			}

			return json_encode(['status' => 'success', 'data' => $data]);
		}

		return json_encode(['status' => 'error', 'data' => []]);
	}

	/**
	 * Delete element
	 *
	 * @param  int $id - brand id
	 * 
	 * @return json
	 */
	public function delete(int $id)
	{
		$locale = $this->viewData['locale'];

		if ((int)$id == 0) {
			$data['error_message'] = lang('RedirectsLang.notFound');
			return json_encode(['status' => 'error', 'data' => $data]);
		}

		$element = $this->redirectsModel->find($id);
		if ($element == null) {
			$data['error_message'] = lang('RedirectsLang.notFound');
			return json_encode(['status' => 'error', 'data' => $data]);
		}

		$deleted = $this->redirectsModel->delete($id);
		if ($deleted !== false) {
			$data['message'] = lang('RedirectsLang.deleted', ['']);
			$data['id'] = $id;
			return json_encode(['status' => 'success', 'data' => $data]);
		} else {
			$data['error_message'] = $this->redirectsModel->errors();
			return json_encode(['status' => 'error', 'data' => $data]);
		}
	}

	/**
	 * Restore element
	 *
	 * @param  int $id - brand id
	 * 
	 * @return json
	 */
	public function restore($id)
	{
		$locale = &$this->viewData['locale'];

		if ((int)$id == 0) {
			$data['error_message'] = lang('RedirectsLang.notFound');
			return json_encode(['status' => 'error', 'data' => $data]);
		}

		$element = $this->redirectsModel->onlyDeleted()->find($id);
		if ($element == null) {
			$data['error_message'] = lang('RedirectsLang.notFound');
			return json_encode(['status' => 'error', 'data' => $data]);
		}

		$restored = $this->redirectsModel->restore($id);

		if ($restored !== false) {
			$data['message'] = lang('RedirectsLang.restored', ['']);
			$data['id'] = $id;
			return json_encode(['status' => 'success', 'data' => $data]);
		} else {
			$data['error_message'] = $this->redirectsModel->errors();
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
		$field_data_array = $this->redirectsModel->getFieldData();

		foreach ($field_data_array as $field) {
			$return_array[$field->name] = $field->default;
		}

		return $return_array;
	}

	public function handle404()
	{
		// Your custom 404 logic here
		$searchUri = service('request')->uri->getPath();
		$redirectsModel = new \App\Modules\Redirects\Models\RedirectsModel;
		$languagesModel = new \App\Modules\Languages\Models\LanguagesModel();
	 
		//find if it uses a locale  ,regex check
		/*
		$languages = $languagesModel->getElements();
		$matched = false;
		foreach ($languages as $language) {
			$language = '/' . $language->code . '\//';
			if (preg_match($language, $searchUri)) {
				$matched = true;
				$localeUri = $searchUri;
				break;
			}
		}

		//add locale if not available
		if ($matched == false) {
			$locale = $this->viewData['locale'];
			$localeUri = $locale . '/' . $searchUri;
		}
		*/
		//end of regex check
	 
		$result = $redirectsModel->like('source', $searchUri, 'before')->first();
		 	
		if ($result != false) {
			$save = [];
			$save['id'] = $result->id;
			$save['count_usage'] = $result->count_usage + 1;

			$redirectsModel->save($save);
 			
			return redirect()->to($result->target, (int) $result->code);
			exit;
		}else{

			return redirect()->route('error_404');
		}

	}
}
