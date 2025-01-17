<?php namespace App\Modules\Admin\Controllers;

//use App\Modules\Admin\Models\AdminModel;
use CodeIgniter\Controller;

class AdminAdminController extends BaseController
{
   public $viewData;
   protected $AdminModel;
   protected $session;
   protected $adminAccessOption;
   protected $languagesModel;

    /**
     * Constructor.
     */
    public function __construct()
    {
		$this->AdminModel = model('App\Modules\Admin\Models\AdminModel', false);
		
		$this->languagesModel = model('App\Modules\Languages\Models\LanguagesModel', false);
		
		$this->session = \Config\Services::session();
		$this->viewData['activeMenu'] = 'administrators';
		
		$this->adminAccessOption = [
			'Admin' => lang('AdminPanel.admin'),
			'SuperAdmin' => lang('AdminPanel.superAdmin'),
			'Orders' => lang('AdminPanel.merchant')
		];
    }
	
	//--------------------------------------------------------------------

	/**
	* Retrieve all Administrators
	*/
    public function index($deleted = false)
	{	
		$data = $this->viewData;

		if ($deleted != false) {
			$data['pageTitle'] = lang('AdminPanel.administrators') . lang('AdminPanel.whichDeleted');
		} else {
			$data['pageTitle'] = lang('AdminPanel.administrators');
		}

		$data['view'] = 'App\Modules\Admin\Views\admin_admin_index';
		$data['elements'] = $this->AdminModel->getAdministrators($deleted);
		$data['adminAccessOption'] = $this->adminAccessOption;
		
		$data['deleted'] = $deleted;

		append_array_to_array($data, $this->viewData);
		
		return view('template/admin', $data);
	}
	
	//--------------------------------------------------------------------
	
	/**
	* Create or edit Administrator
	*/
	public function form($id = 'new', $duplicate = false)
	{
		helper('form');
		helper('dropdown_helper');
		
		$locale = service('request')->getLocale();
		if ($this->request->getMethod() === 'post') {
			$data = $save = $this->request->getPost('save');
		} else {
			if ($id !== 'new') {
			
				$data = $this->AdminModel->asArray()->find($id);
				
				if ($data == null) {
					$this->session->setFlashdata('error', lang('AdminLang.notFound'));
					return redirect()->to('/' . $data['locale'] . '/admin/administrators');
				}
			} else {
				$data = $this->getFieldNames();
			}
		}
		
		append_array_to_array($data, $this->viewData);

		$data['pageTitle'] = lang('AdminLang.edit');
		
		$data['view'] = 'App\Modules\Admin\Views\admin_admin_form';
		$data['duplicate'] = $duplicate;
		$data['id'] = $id;
		
		$data['languagesArray'] = prepare_dropdown($this->languagesModel->getElements('admin'), 'uri', 'native_name');
		
		$data['adminAccessOption'] = $this->adminAccessOption;

		if ($id !== 'new') {
			$save['id'] = $id;

			if ($this->request->getPost('save[password]') != '' || $this->request->getPost('save[confirm]') != '') {
				$getRule = $this->AdminModel->getRule('editAdministratorWithPassword');
			} else {
				$getRule = $this->AdminModel->getRule('editAdministrator');
			}
		} else {
			$data['language'] = '0';
			
			$save['id'] = false;
			$getRule = $this->AdminModel->getRule('createAdministrator');
			
			$data['pageTitle'] = lang('AdminLang.add');
		}
		
		if ($duplicate !== false) {
			$data['id']	= 'new';
			$data['pageTitle'] = lang('AdminLang.copy');
		}
		
		$this->AdminModel->setValidationRules($getRule);
		
		if ($this->request->getMethod() === 'post') {

			$lastInsertId = $this->AdminModel->saveAdministrator($save);
			
			if ($lastInsertId != false) {

				//$link = '<a href="' . site_url('admin/administrators/form/' . $lastInsertId) . '">Edit</a>';
				
				$this->session->setFlashdata('message', lang('AdminLang.elementSaved', [
					$save['firstname'] . ' ' . $save['lastname'],
					'<a href="' . site_url($data['locale'] . '/admin/administrators/form/' . $lastInsertId) . '">'. lang('AdminPanel.edit') .'</a>'
				]));
				
				if ($this->request->getPost('submit_save_and_return') !== null) {
					return redirect()->to('/' . $data['locale'] . '/admin/administrators/form/' . $lastInsertId);
				} else {
					return redirect()->to('/' . $data['locale'] . '/admin/administrators');
				}
			} else {
				$data['errors'] = $this->AdminModel->errors();
			}
		}

		return view('template/admin', $data);
	}
	
	//--------------------------------------------------------------------

	/**
	* Retrieves database columns data to set defaults in the forms
	*/
	private function getFieldNames()
	{
		$return_array = [];
		$field_data_array = $this->AdminModel->getFieldData();
		
		foreach ($field_data_array as $field) {
			$return_array[$field->name] = $field->default;
		}
		
		return $return_array;
	}
	
	//--------------------------------------------------------------------

	/**
	* Delete Administrator
	*/
	public function delete($id)
	{
		$locale = $this->viewData['locale'];
		
		if ((int)$id == 0) {
			$this->session->setFlashdata('error', lang('AdminLang.notFound'));
			return redirect()->to('/' . $locale . '/admin/administrators');
		}
		
		//TODO
		$myId = 1;
		
		$data = $this->AdminModel->getOtherAdministrator($id, $myId);
		if ($data == null) {
			$this->session->setFlashdata('error', lang('AdminLang.notFound'));
			return redirect()->to('/' . $locale . '/admin/administrators');
		}

		$deleted = $this->AdminModel->delete($id);
		
		if ($deleted !== false) {
			
			$this->session->setFlashdata('message', lang('AdminLang.elementDeleted', [
				$data->firstname . ' ' . $data->lastname,
				'<a href="' . site_url('/' . $locale . '/admin/administrators/restore/' . $id) . '">'. lang('AdminLang.undoDelete') .'</a>'
			]));
			
			return redirect()->to('/' . $locale . '/admin/administrators');
		} else {
			$this->session->setFlashdata('error', $this->AdminModel->errors());
			return redirect()->to('/' . $locale . '/admin/administrators');
		}
	}
	
	
	public function restore($id)
	{
		$locale = $this->viewData['locale'];
		
		if ((int)$id == 0) {
			$this->session->setFlashdata('error', lang('AdminLang.notFound'));
			return redirect()->to('/' . $locale . '/admin/administrators');
		}
		
		$data = $this->AdminModel->onlyDeleted()->find($id);
		if ($data == null) {
			$this->session->setFlashdata('error', lang('AdminLang.notFound'));
			return redirect()->to('/' . $locale . '/admin/administrators');
		}

		$restored = $this->AdminModel->restore($id);
		
		if ($restored !== false) {
			$this->session->setFlashdata('message', lang('AdminLang.elementRestored', [$data->firstname . ' ' . $data->lastname]));
			return redirect()->to('/' . $locale . '/admin/administrators');
		} else {
			$this->session->setFlashdata('error', $this->AdminModel->errors());
			return redirect()->to('/' . $locale . '/admin/administrators');
		}
	}

}
