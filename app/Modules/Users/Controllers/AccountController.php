<?php

namespace App\Modules\Users\Controllers;

use CodeIgniter\Controller;
//use Config\Email;
use Config\Services;

class AccountController extends Controller
{
	/**
	 * Access to current session.
	 *
	 * @var \CodeIgniter\Session\Session
	 */
	protected $session;
	protected $language;
	protected $usersModel;
	protected $locale;

	/**
	 * Authentication settings.
	 */
	protected $config;
	//protected $AdminModel;

	public function __construct()
	{
		// start session
		$this->session = Services::session();

		$this->language = Services::language();

		$this->usersModel = new \App\Modules\Users\Models\UsersModel;

		// load auth settings
		$this->config = new \Config\App();

		$this->locale = service('request')->getLocale();
	}

	//--------------------------------------------------------------------

	/**
	 * Displays login form or redirects if user is already logged in.
	 */
	public function showLogin()
	{
		if ($this->session->isLoggedIn) {
			return redirect()->to(site_url($this->locale));
		}

		$data = [
			'view' => 'App\Modules\Users\Views\login',
			'activeMenuItem' => 'login',
			'locale' => service('request')->getLocale(),
		];

		helper('form');
		return view('template/layout', $data);
	}

	/**
	 * Displays register form or redirects if user is already logged in.
	 */
	public function showRegister()
	{
		if ($this->session->isLoggedIn) {
			return redirect()->to(site_url($this->locale));
		}

		$data = [
			'view' => 'App\Modules\Users\Views\register',
			'locale' => service('request')->getLocale(),
		];

		helper('form');
		return view('template/layout', $data);
	}

	/**
	 * Displays my account page
	 */
	public function showMyAccount()
	{
		if (!$this->session->isLoggedIn) {
			return redirect()->to(site_url($this->locale));
		}

		$customerEmail = session()->userData['email'];

		$customer = $this->usersModel->where('email', $customerEmail)->first();

		if (!$customer) {
			return $this->logout();
		}

		//get the orders by account

		$ordersController = new \App\Modules\Orders\Controllers\OrdersController;
		$myOrders = $ordersController->getOrdersByAccount($customer->id);

		//bonito club
		$cart = new \App\Modules\Cart\Libraries\Cart();
		$loyalClientsDiscount = $cart->getLoyalClientsDiscount($customer->start_turnover + $customer->turnover, 0);

		$data = [
			'view' => 'App\Modules\Users\Views\my_account',
			'locale' => service('request')->getLocale(),
			'customer' => $customer,
			'myOrders' => $myOrders,
			'turnover' => $customer->start_turnover + $customer->turnover,
			'percent_loyalclient' => $loyalClientsDiscount['percent'],
		];

		helper('form');
		return view('template/layout', $data);
	}

	/**
	 * Displays order detail
	 */
	public function showOrder($id)
	{
		if (!$this->session->isLoggedIn) {
			return redirect()->to(site_url($this->locale));
		}

		$customerEmail = session()->userData['email'];

		$customer = $this->usersModel->where('email', $customerEmail)->first();

		if (!$customer) {
			return $this->logout();
		}

		//get the order by account

		$ordersModel = new \App\Modules\Orders\Models\OrdersModel;
		$order = $ordersModel->where('customer_id', $customer->id)->asArray()->find($id);

		if (!$order) {
			return redirect()->to(site_url($this->locale . '/users/myaccount'));
		}

		$data = [
			'view' => 'App\Modules\Users\Views\order_details',
			'locale' => service('request')->getLocale(),
			'customer' => $customer,
			'order' => $order ?? [],
		];

		helper('dropdown');
		$cart = new \App\Modules\Cart\Libraries\Cart;

		$shippingMethods = $cart->getActiveShipping();
		$data['shippingMethods'] = prepare_dropdown($shippingMethods, 'shipping_id', 'title');

		$orderItemsModel = new \App\Modules\Orders\Models\OrderItemsModel;
		$data['products'] = $orderItemsModel->where('order_id', $id)->asArray()->find();

		//$orderInformationModel = new \App\Modules\Orders\Models\orderInformationModel;
		//$data['order_information'] = $orderInformationModel->where('order_id', $id)->find();

		return view('template/layout', $data);
	}


	public function changePassword()
	{
		helper('form');

		$rules = [
			'newPassword' => 'required|min_length[6]|max_length[50]',
			'confirmPassword'  => 'matches[newPassword]'
		];

		if ($this->validate($rules)) {

			$customerEmail = $this->request->getVar('email');
			$customer = $this->usersModel->where('email', $customerEmail)->first();

			$password = $this->request->getVar('newPassword');

			if (password_verify($password, $customer->password)) {
				$user_data = [
					'id' => $customer->id,
					'password' => $password
				];

				$this->usersModel->saveUser($user_data);

				return redirect()
					->to(site_url($this->locale . '/users/myaccount'))
					->withInput()->with('message', lang('AccountLang.passwordChangeSuccessfully'));
			} else {
				return redirect()->to(site_url($this->locale . '/users/myaccount'))
					->withInput()
					->with('error', lang('AccountLang.wrongOldPassword'));
			}
		} else {
			return redirect()->to(site_url($this->locale . '/users/myaccount'))
				->withInput()
				->with('errors', $this->validator->getErrors());
		}
	}

	/**
	 * Displays password reset page
	 */
	public function showPasswordReset()
	{
		if ($this->session->isLoggedIn) {
			return redirect()->to(site_url($this->locale));
		}

		$data = [
			'view' => 'App\Modules\Users\Views\password_reset',
			'locale' => service('request')->getLocale(),
			'moduleJS' => []
		];

		helper('form');
		return view('template/layout', $data);
	}

	/**
	 * Activation account action
	 */
	public function showActivationPage($token)
	{
		if ($this->session->isLoggedIn) {
			return redirect()->to(site_url($this->locale));
		}

		$data = [
			'locale' => service('request')->getLocale(),
		];

		$result = $this->usersModel->getUserByToken($token);
		 
		if($result != null) {

			$user_data = [
				'id' => $result->id,
				'active' => 1,
				'password_reset_token' => null 
			];

			$this->session->setFlashdata('message', lang('AccountLang.activate'));

			$this->session->getFlashdata('message');

			$this->usersModel->saveUser($user_data);

		}else{
			$this->session->setFlashdata('error', lang('AccountLang.activate_error'));

			$this->session->getFlashdata('error');
		}

		helper('form');
		return redirect()->to('/' . $data['locale'] . '/users/login/');
	}


	public function setNewCustomerPassword()
	{
		//helper('form');

		$rules = [
			'newPassword' => [
				'rules'  => 'required|min_length[6]|max_length[50]',
				'label'  => lang('AccountLang.newPassword'),
			],
			'confirmPassword' => [
				'rules'  => 'matches[newPassword]',
				'label'  => lang('AccountLang.confirmPassword'),
			]
		];

		if (!$this->validate($rules)) {
			return redirect()->to(site_url($this->locale . '/users/password/reset/' . $this->request->getVar('token')))
				->withInput()
				->with('errors', $this->validator->getErrors());
		}

		$customer = $this->usersModel->where('password_reset_token', $this->request->getVar('token'))->first();

		if ($customer == null) {
			return redirect()->to(site_url($this->locale . '/users/password/reset/' . $this->request->getVar('token')))
				->withInput()
				->with('error', lang('AccountLang.linkNotValid'));
		}

		$user_data = [
			'id' => $customer->id,
			'password' => $this->request->getVar('newPassword'),
			'password_reset_token' => NULL,
			'password_reset_date' => NULL
		];

		$this->usersModel->saveUser($user_data);

		return redirect()->to(site_url($this->locale . '/users/login'));
	}

	public function resetPassword($token = false)
	{
		if ($this->session->isLoggedIn) {
			return redirect()
				->to(site_url($this->locale))
				->with('message', lang('AccountLang.alreadyLoggedIn'));
		}

		$resetExpirationTime = 3600; // Set 1 hour expiration date

		if ($token) {
			$user = $this->usersModel->where('password_reset_token', $token)->first();

			if (!empty($user->password_reset_date) && (int) $user->password_reset_date + $resetExpirationTime < time()) {
				return redirect()
					->to(site_url($this->locale . '/users/password/reset'))
					->withInput()->with('error', lang('AccountLang.linkAlreadyExpired'));
			}

			$data = [
				'view' => 'App\Modules\Users\Views\new_password',
				'locale' => service('request')->getLocale(),
				'token' => $token
			];

			helper('form');

			return view('template/layout', $data);
		}

		// validate request
		if ($this->validate(['email' => 'required|valid_email'])) {
			// check if email exists in DB
			$customerEmail = $this->request->getPost('email');
			$user = $this->usersModel->where('email', $customerEmail)->first();

			if ($user) {
				$passwordResetSentDate = (int) $user->password_reset_date;

				if (empty($user->password_reset_date) || ($passwordResetSentDate + $resetExpirationTime <= time())) {
					helper('text');

					// Generate token for reset password link
					$token = random_string_pool(32, 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789');

					// Save generated token and sent date
					$user_data = [
						'id' => $user->id,
						'password_reset_token' => $token,
						'password_reset_date' => time()
					];

					$this->usersModel->saveUser($user_data);

					// Send password reset e-mail
					$emailResult = $this->password_reset_send_email($customerEmail, $token);
					if ($emailResult !== true) {

						$user_data = [
							'id' => $user->id,
							'password_reset_token' => null,
							'password_reset_date' => null
						];

						$this->usersModel->saveUser($user_data);

						return redirect()
							->to(site_url($this->locale . '/users/password/reset'))
							->withInput()->with('error', $emailResult);
					}

					unset($_POST);

					return redirect()
						->to(site_url($this->locale . '/users/password/reset'))
						->withInput()->with('message', lang('AccountLang.emailSentSuccessfully'));
				} else {
					return redirect()
						->to(site_url($this->locale . '/users/password/reset'))
						->withInput()->with('error', lang('AccountLang.emailAlreadySent'));
				}
			} else {
				return redirect()
					->to(site_url($this->locale . '/users/password/reset'))
					->withInput()->with('error', lang('AccountLang.wrongEmail'));
			}
		} else {
			return redirect()
				->to(site_url($this->locale . '/users/password/reset'))
				->withInput()->with('error', lang('AccountLang.invalidEmail'));
		}
	}

	public function password_reset_send_email($customerEmail, $token)
	{
		helper('email');

		$settingsModel = new \App\Modules\Settings\Models\SettingsModel;
		$passwordResetEmailTemplate = $settingsModel->getElement('password_reset_email_template', $this->locale);

		$content = str_replace('{{token}}', site_url($this->locale . '/users/password/reset/' . $token), $passwordResetEmailTemplate->setup_value);

		$siteEmail = $settingsModel->getElement('site_email', $this->locale);
		$metaSiteName = $settingsModel->getElement('meta_site_name', $this->locale);

		$emailProperties = [
			'to' => $customerEmail,
			'from' => $siteEmail->setup_value,
			'from_name' => $metaSiteName->setup_value,
			'subject' => lang('AccountLang.passwordResetRequest'),
			'content' => $content,
		];

		return send_html_email($emailProperties);
	}

	public function activate_account_send_email($customerEmail, $token)
	{
		helper('email');

		$settingsModel = new \App\Modules\Settings\Models\SettingsModel;

		$subject = $settingsModel->getElement('title_activate_account', $this->locale);
		$activateEmailTemplate = $settingsModel->getElement('activate_account_email_template', $this->locale);

		$content = str_replace('{{token}}', site_url($this->locale . '/users/activate/' . $token), $activateEmailTemplate->setup_value);

		$siteEmail = $settingsModel->getElement('site_email', $this->locale);
		$metaSiteName = $settingsModel->getElement('meta_site_name', $this->locale);

		$emailProperties = [
			'to' => $customerEmail,
			'from' => $siteEmail->setup_value,
			'from_name' => $metaSiteName->setup_value,
			'subject' => $subject->setup_value,
			'content' => $content,
		];

		return send_html_email($emailProperties);
	}

	/**
	 * Attempts to verify user's credentials through POST request.
	 */
	public function attemptLogin()
	{
		// validate request
		$rules = [
			'email'		=> 'required|valid_email',
			'password' 	=> 'required|min_length[6]',
		];

		if (!$this->validate($rules)) {
			return redirect()->to(site_url($this->locale . '/users/login'))
				->withInput()
				->with('errors', $this->validator->getErrors());
		}

		$email = $this->request->getPost('email');
		$password = $this->request->getPost('password');

		// check credentials
		$user = $this->usersModel->where('email', $email)->first();

		if (!empty($user) && !password_verify($password, $user->password)) {
			return redirect()
				->to(site_url($this->locale . '/users/login'))
				->withInput()->with('error', lang('AccountLang.wrongPassword'));
		}

		if (is_null($user) || $user->active === '0') {
			return redirect()
				->to(site_url($this->locale . '/users/login'))
				->withInput()->with('error', lang('AccountLang.accessDenied'));
		}

		$subscriptionsModel = new \App\Modules\Users\Models\SubscriptionsModel;
		$subscription = $subscriptionsModel->where(['email' => $user->email, 'active' => '1'])->countAllResults();

		// login OK, save user data to session
		$this->session->set('isLoggedIn', true);
		$this->session->set('userData', [
			'id' => $user->id,
			'firstname' => $user->firstname,
			'lastname' => $user->lastname,
			'phone_number' => $user->phone_number,
			'email' => $user->email,
			'subscription' => $subscription
		]);

		if ($user->language != '') {
			$this->language->setLocale($user->language);

			$user->language .= '/';
		}

		$redirect_url = site_url('users/myaccount');

		// d($this->session->redirect_url); exit;

		if (isset($this->session->redirect_url)) {
			$redirect_url = $this->session->redirect_url;
		}

		return redirect()
			->to($redirect_url)
			->with('message', lang('AccountLang.loginSuccess'));
	}

	public function attemptRegister()
	{

		helper('form');
		helper('text');

		$rules = [
			'firstname' => 'required|min_length[2]|max_length[50]',
			'lastname' => 'required|min_length[2]|max_length[50]',
			'phoneNumber' => 'required|min_length[10]|max_length[13]',
			'city' => 'required',
			'email' => 'required|min_length[4]|max_length[100]|valid_email|is_unique[users.email]',
			'password' => 'required|min_length[6]|max_length[50]',
			'confirmPassword'  => 'matches[password]'
		];

		if ($this->validate($rules)) {
			$token = random_string_pool(32, 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789');

			$user_data = [
				'id' => false,
				'firstname' => $this->request->getVar('firstname'),
				'lastname' => $this->request->getVar('lastname'),
				'phone_number' => $this->request->getVar('phoneNumber'),
				'city' => $this->request->getVar('city'),
				'email' => $this->request->getVar('email'),
				'password' => $this->request->getVar('password'),
				'language' => $this->locale,
				'active' => 0,
				'password_reset_token' => $token
			];


			$this->activate_account_send_email($user_data['email'], $token);

			$this->usersModel->saveUser($user_data);
			// Authenticate customer if the registration was successful
			//$this->session->set('isLoggedIn', true);
			//$this->session->set('userData', $user_data);

			$this->session->setFlashdata('message', lang('AccountLang.register'));
	
			$this->session->getFlashdata('message');

			return redirect()->to(site_url($this->locale . '/users/login'));
		} else {
			return redirect()->to(site_url($this->locale . '/users/register'))
				->withInput()
				->with('errors', $this->validator->getErrors());
		}
	}


	public function registerAfterCheckout($incomingUserData)
	{
		helper('text');

		//check for user existsing
		$user = $this->usersModel->where('email', $incomingUserData['email'])->first();

		if ($user != null) {
			return true;
		}

		$rules = [
			'firstname' => 'required|min_length[2]|max_length[50]',
			'lastname' => 'required|min_length[2]|max_length[50]',
			'phone_number' => 'required|min_length[10]|max_length[13]',
			'city' => 'required',
			'email' => 'required|min_length[4]|max_length[100]|valid_email|is_unique[users.email]',
		];

		$userData = [
			'id' => false,
			'firstname' => explode(' ', $incomingUserData['name'])[0],
			'lastname' => explode(' ', $incomingUserData['name'])[1] ?? '',
			'phone_number' => $incomingUserData['phone'],
			'city' => $incomingUserData['city'],
			'email' => $incomingUserData['email'],
			'password' => random_string_pool(6, 'ABFGHKLMNPRSTUVWXYZ0123456789'),
			'language' => $this->locale
		];

		$validation = \Config\Services::validation();

		$validation->setRules($rules);

		if ($validation->run($userData)) {

			$lastInsertId = $this->usersModel->saveUser($userData);

			// Authenticate customer if the registration was successful
			$this->session->set('isLoggedIn', true);

			$this->session->set('userData', [
				'id' => $lastInsertId,
				'firstname' => $userData['firstname'],
				'lastname' => $userData['lastname'],
				'phone_number' => $userData['phone_number'],
				'email' => $userData['email']
			]);

			return $lastInsertId;
		} else {
			return $validation->getErrors();
		}
	}

	/**
	 * Log the user out.
	 */
	public function logout()
	{
		//echo 'da';exit;
		$this->session->remove(['isLoggedIn', 'userData', 'redirect_url']);

		return redirect()->to(site_url($this->locale));
	}


	public function editAccount()
	{
		helper('form');

		$firstname = $this->request->getVar('firstname');
		$lastname = $this->request->getVar('lastname');
		$phoneNumber = $this->request->getVar('phoneNumber');
		$city = $this->request->getVar('city');
		$password = $this->request->getVar('password');
		$confirmPassword = $this->request->getVar('confirmPassword');
		$customerEmail = $this->request->getVar('email');

		$rules = [];

		$rules['firstname'] = [
			'label' => lang('AccountLang.firstname'),
			'rules' => 'trim|required|max_length[64]',
		];
		$rules['lastname'] = [
			'label' => lang('AccountLang.lastname'),
			'rules' => 'trim|required|max_length[64]',
		];
		$rules['phoneNumber'] = [
			'label' => lang('AccountLang.phoneNumber'),
			'rules' => 'trim|required|max_length[20]',
		];
		$rules['city'] = [
			'label' => lang('AccountLang.city'),
			'rules' => 'trim|required|max_length[255]',
		];

		if ($password != '') {
			$rules['password'] = [
				'label' => lang('AccountLang.newPassword'),
				'rules' => 'trim|required|min_length[6]|max_length[50]',
			];
			$rules['confirmPassword'] = [
				'label' => lang('AccountLang.confirmPassword'),
				'rules' => 'trim|required|matches[password]',
			];
		}

		if ($this->validate($rules)) {

			$customer = $this->usersModel->where('email', $customerEmail)->first();

			$user_data = [
				'id' => $customer->id,
				'firstname' => $firstname,
				'lastname' => $lastname,
				'password' => $password,
				'phone_number' => $phoneNumber,
				'city' => $city,
			];

			$this->usersModel->saveUser($user_data);

			return redirect()
				->to(site_url($this->locale . '/users/myaccount'))
				->withInput()->with('message', lang('AccountLang.accountSaved'));
		} else {
			return redirect()->to(site_url($this->locale . '/users/myaccount'))
				->withInput()
				->with('errors', $this->validator->getErrors());
		}
	}
}
