<?php namespace App\Modules\Users\Controllers;

class UsersController extends BaseController
{
	protected $session;
	protected $languagesModel;
	protected $usersModel;

	public function __construct()
	{
		$this->languagesModel = new \App\Modules\Languages\Models\LanguagesModel;
		$this->usersModel = new \App\Modules\Users\Models\UsersModel;

		$this->session = \Config\Services::session();
		$this->viewData['activeMenu'] = 'users';
	}

	//--------------------------------------------------------------------
	public function index(int $page = 1, $deleted = false)
	{
		helper('form');

		$cart = new \App\Modules\Cart\Libraries\Cart();

		$uri = service('uri');
		if ($page == 1 && $uri->getSegment($uri->getTotalSegments()) != 1) {
			$segment = $uri->getTotalSegments() + 1;
		} else {
			$segment = $uri->getTotalSegments();
		}

		$elements = $this->getAllUsers($deleted, [], $page, $segment);

		$data = [
			'view' => 'App\Modules\Users\Views\users_index',
			'lastEdidtedId' => $this->session->getFlashdata('lastEdidtedId'),
			'are_you_sure' => 'App\Views\template\are_you_sure',
			'pageTitle' => (($deleted != false) ? lang('UsersLang.users') . lang('AdminPanel.whichDeleted') : lang('UsersLang.users')),
			'page' => $page,
			'id' => '',
			'elements' => $elements['elements'],
			'pager' => $elements['pager'],
			'deleted' => $deleted,
			'javascript' => ['App\Modules\Users\Views\users_js', 'App\Views\template\modals',],
		];

		if ($deleted != false) {
			unset($this->viewData['useSearch']);
		}

		$this->session->setFlashdata('lastEdidtedId', $data['lastEdidtedId']);

		foreach ($data['elements'] as &$element) {
			$loyalClientsDiscount = $cart->getLoyalClientsDiscount($element->start_turnover + $element->turnover, 0);
			$element->percent_loyalclient = $loyalClientsDiscount['percent'];
		}

		append_array_to_array($data, $this->viewData);

		if ($this->request->isAJAX()) {

			$data['isAjax'] = true;

			return view('App\Modules\Users\Views\users_index_ajax', $data);
		}

		$data['isAjaxRequest'] = true;
		$data['duplicate'] = false;

		return view('template/admin', $data);
	}
	
	/**
	 * Gets all elements with default site language title
	 *
	 * @param  bool $deleted - to display deleted elements or not
	 * @param  array $filterData
	 * @param  int $page - pagination
	 *
	 * @return array
	 */
	public function getAllUsers($deleted = false, array $filterData = [], int $page = 1, $segment = 4) : array
	{
		$returnArray = [];
		
		$data['config'] = config('App\Modules\Users\Config\Users', false);

		if ($deleted != false) {
			$elements = $this->usersModel->getElements($deleted, $filterData)->onlyDeleted()->paginate(10000, 'group', $page, $segment);
		} else {
			$elements = $this->usersModel->getElements($deleted, $filterData)->paginate($data['config']->elementsPerPage, 'group', $page, $segment);
		}
		
		$_pager = $this->usersModel->pager;

		$returnArray['elements'] = $elements;  // No need to call findAll() here
		$returnArray['pager'] = $_pager;
		
		return $returnArray;
	}

	/**
	 * Display list of found elements using AJAX
	 *
	 * @param  int $page - to display page
	 *
	 * @return void
	 */

	 public function search($page = 1, $deleted = false)
	 {
		$cart = new \App\Modules\Cart\Libraries\Cart();

		 //$postArray = $this->request->getPost();
 
		 $searchText = $this->request->getPost('top-search-text');
 
		 if ($searchText == '' && $page >= 1) {
			 $searchText = $this->session->getFlashdata('searchText');
			 $this->session->setFlashdata('searchText', $searchText);
		 } else {
			 $this->session->setFlashdata('searchText', $searchText);
		 }
 
		 $searchArray = [];
		 //key value pairs for table field => value
		 if ($searchText != '') {
			 $searchArray = [
				 'id' => $searchText,
				 'email' => $searchText,
				 'firstname' => $searchText,
				 'lastname' => $searchText,
			 ];
		 }
		 
		 $activeOptions = [
			 1 => lang('AdminPanel.active'),
			 0 => lang('AdminPanel.inactive'),
		 ];
 
		 if (array_search($searchText, $activeOptions, true) !== false) {
			 $searchArray['active'] = array_search($searchText, $activeOptions, true);
		 }
 
		 $data = $this->viewData;
		 $data['deleted'] = $deleted;
		 $data['page'] = $page;
 
		 $uri = service('uri');
		 if ($page == 1 && $uri->getSegment($uri->getTotalSegments()) != 1) {
			 $segment = $uri->getTotalSegments() + 1;
		 } else {
			 $segment = $uri->getTotalSegments();
		 }
 
		 $elements = $this->getAllUsers($deleted, $searchArray, $page, $segment);
		 $data['elements'] = $elements['elements'];
		 $data['pager'] = $elements['pager'];

		$data['isAjax'] = true;
 
		foreach ($data['elements'] as &$element) {
			$loyalClientsDiscount = $cart->getLoyalClientsDiscount($element->start_turnover + $element->turnover, 0);
			$element->percent_loyalclient = $loyalClientsDiscount['percent'];
		}

		 $data['lastEdidtedId'] = $this->session->getFlashdata('lastEdidtedId');
		 $this->session->setFlashdata('lastEdidtedId', $data['lastEdidtedId']);
 
		 return view('App\Modules\Users\Views\users_index_ajax', $data);
	 }

	//--------------------------------------------------------------------
	/*
	public function getUsers()
	{
		$users = $this->usersModel->asArray()->find();

		return $this->response->setJSON([
			'users' => $users,
		]);
	}
	*/
	//--------------------------------------------------------------------

	/**
	* Create or edit User
	*/
	public function form($id = 'new', $duplicate = false)
	{
		//$localeUrlAdmin = $this->viewData['localeUrlAdmin'];

		helper('form');
		helper('dropdown_helper');

		if ($this->request->getMethod() === 'post') {
			$data = $save = $this->request->getPost('save');
		}

		$data['percent_loyalclient'] = 0;
		
		if ($id !== 'new') {
			$data = $this->usersModel->asArray()->find($id);
			$save['id'] = $id;

			$data['pageTitle'] = lang('UsersLang.edit');

			if ($this->request->getPost('save[password]') != '' || $this->request->getPost('save[confirm]') != '') {
				$getRule = $this->usersModel->getRule('editUserWithPassword');
			} else {
				$getRule = $this->usersModel->getRule('editUser');
			}

			//processing loyalclients discount
			$cart = new \App\Modules\Cart\Libraries\Cart();
			$loyalClientsDiscount = $cart->getLoyalClientsDiscount($data['start_turnover'] + $data['turnover'], 0);
			$data['percent_loyalclient'] = $loyalClientsDiscount['percent'];

			if ($data == null) {
				return json_encode(['status' => 'error', 'data' => $data, 'error_message' => lang('UsersLang.notFound')]);
			}

		} else {
			$data = $this->getFieldNames();

			$data['language'] = '0';
			$save['id'] = false;
			$getRule = $this->usersModel->getRule('createUser');

			$data['percent_loyalclient'] = 0;

			$data['pageTitle'] = lang('UsersLang.add');
		}

		append_array_to_array($data, $this->viewData);

		$data['duplicate'] = $duplicate;

		if (!$this->request->isAJAX()) {
			$data['pageTitle'] = lang('UsersLang.users');
			$data['isAjaxRequest'] = false;
			$data['view'] = 'App\Modules\Users\Views\users_index';
			$data['javascript'] = [
				'App\Modules\Users\Views\users_js',
				'App\Views\template\modals',
			];

			$data['lastEdidtedId'] = $this->session->getFlashdata('lastEdidtedId');
			$this->session->setFlashdata('lastEdidtedId', $data['lastEdidtedId']);

			$elements = $this->getAllUsers(false, [], 1);
			$data['elements'] = $elements['elements'];
			$data['pager'] = $elements['pager'];
			
			//d($data['elements']);
			$data['deleted'] = false;
			$data['page'] = 1;

			$cart = new \App\Modules\Cart\Libraries\Cart();

			foreach ($data['elements'] as &$element) {
				$loyalClientsDiscount = $cart->getLoyalClientsDiscount($element->start_turnover + $element->turnover, 0);
				$element->percent_loyalclient = $loyalClientsDiscount['percent'];
			}
			
			return view('template/admin', $data);
		}

		$data['isNotAjaxRequest'] = false;

		$data['id'] = $id;

		if ($duplicate !== false) {
			$data['id']	= 'new';

			$data['pageTitle'] = lang('UsersLang.copy');
		}

		$this->usersModel->setValidationRules($getRule);

		if ($this->request->getMethod() === 'post') {

			$lastInsertId = $this->usersModel->saveUser($save);

			if ($lastInsertId != false) {

				$this->session->setFlashdata('message', lang('UsersLang.elementSaved', [
					$save['firstname'] . ' ' . $save['lastname'],
					'<a href="' . site_url($data['locale'] . '/admin/users/form/' . $lastInsertId) . '">'. lang('UsersLang.edit') .'</a>'
				]));

			} else {
				$data['errors'] = $this->usersModel->errors();
			}
		}

		//for future use - if needs language
		//$data['languagesArray'] = prepare_dropdown($this->languagesModel->getElements('admin'), 'uri', 'native_name');

		$data['view'] = view('App\Modules\Users\Views\users_form', $data);
		
		return json_encode(['status' => 'success', 'data' => $data]);
	}

	/**
	 * Processes the form data
	 *
	 * @param  mixed $id - users id
	 * 
	 * @return json
	 */
	public function form_submit($id = 'new')
	{
		if ($this->request->getMethod() === 'post') {
			
			$save = $this->request->getPost('save');

			if ($id !== 'new') {
				$save['id'] = $id;
			} else {
				$save['id'] = false;
			}

			$lastInsertId = $this->usersModel->saveUser($save);

			if ($lastInsertId != false) {
				
				$data['id'] = $lastInsertId;

				$flagNoErrorMessages = true;

				if ($flagNoErrorMessages) {
					$data['message'] = lang('UsersLang.saved');
				}
				
				$this->session->setFlashdata('lastEdidtedId', $lastInsertId);
				
			} else {

				$data['id'] = $id;

				$data['error_message'] = $this->usersModel->errors();

				return json_encode(['status' => 'error', 'data' => $data]);
			}
			
			return json_encode(['status' => 'success', 'data' => $data]);
		}
		
		return json_encode(['status' => 'error', 'data' => []]);
	}

	//--------------------------------------------------------------------

	/**
	* Retrieves database columns data to set defaults in the forms
	*/
	private function getFieldNames()
	{
		$return_array = [];

		$field_data_array = $this->usersModel->getFieldData();

		foreach ($field_data_array as $field) {
			$return_array[$field->name] = $field->default;
		}

		return $return_array;
	}

	//--------------------------------------------------------------------

	/**
	* Delete User
	*/
	public function delete($id)
	{
		$locale = $this->viewData['locale'];

		$data['page'] = '';

		if ((int)$id == 0) {
			$data['error_message'] = lang('UsersLang.notFound');
			return json_encode(['status' => 'error', 'data' => $data]);
		}

		$element = $this->usersModel->getUser($id);
		if ($element == null) {
			$data['error_message'] = lang('UsersLang.notFound');
			return json_encode(['status' => 'error', 'data' => $data]);
		}

		$deleted = $this->usersModel->delete($id);

		if ($deleted !== false) {
			$data['message'] = lang('UsersLang.elementDeleted', [
				$element->firstname . ' ' . $element->lastname, 
				'',
			]);
			$data['id'] = $id;
			return json_encode(['status' => 'success', 'data' => $data]);
		} else {
			$data['error_message'] = $this->usersModel->errors();
			return json_encode(['status' => 'error', 'data' => $data]);
		}
	}

	/**
	* Restore User
	*/
	public function restore($id)
	{
		$locale = $this->viewData['locale'];

		if ((int)$id == 0) {
			$data['error_message'] = lang('UsersLang.notFound');
			return json_encode(['status' => 'error', 'data' => $data]);
		}

		$element = $this->usersModel->onlyDeleted()->find($id);
		if ($element == null) {
			$data['error_message'] = lang('UsersLang.notFound');
			return json_encode(['status' => 'error', 'data' => $data]);
		}

		$restored = $this->usersModel->restore($id);

		if ($restored !== false) {
			$data['message'] = lang('UsersLang.elementRestored', [$element->firstname . ' ' . $element->lastname]);
			$data['id'] = $id;
			return json_encode(['status' => 'success', 'data' => $data]);
		} else {
			$data['error_message'] = $this->usersModel->errors();
			return json_encode(['status' => 'error', 'data' => $data]);
		}
	}
}