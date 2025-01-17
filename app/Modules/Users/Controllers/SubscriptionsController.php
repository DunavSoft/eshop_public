<?php

namespace App\Modules\Users\Controllers;

use CodeIgniter\Controller;
use Config\Services;

/**
 * Class SubscriptionsController
 * @package App\Modules\Users\Controllers
 */
class SubscriptionsController extends BaseController
{
	/**
	 * Access to current session.
	 *
	 * @var \CodeIgniter\Session\Session
	 */
	protected $session;

	/**
	 * Authentication settings.
	 */
	protected $config;
	protected $subscriptionsModel;

	public function __construct()
	{
		$this->config = new \Config\App();
		$this->session = Services::session();

		$this->viewData['activeMenu'] = 'subscriptions';
		$this->viewData['useSearch'] = true;
		$this->viewData['config'] = config('App\Modules\Users\Config\Subscriptions');

		$this->subscriptionsModel = new \App\Modules\Users\Models\SubscriptionsModel;
	}

	/**
	 * Displays subscribers list
	 * getSubscriptionsPaginate
	 */
	public function showSubscribersList(int $page = 1)
	{
		helper('form');

		$data = [
			'view' => 'App\Modules\Users\Views\admin\subscriptions_list',
			'pageTitle' => lang('SubscriptionsLang.pageTitle'),
			//'elements' => $elements
		];

		$data['lastEdidtedId'] = $this->session->getFlashdata('lastEdidtedId');
		$this->session->setFlashdata('lastEdidtedId', $data['lastEdidtedId']);

		//$data['lastEdidtedId'] = 1001;

		//$this->articlesModel = new \App\Modules\Articles\Models\ArticlesModel;
		//$this->productsModel = new \App\Modules\Products\Models\ProductsModel;

		$elements = $this->subscriptionsModel->getSubscriptions();

		$uri = service('uri');
		 if ($page == 1 && $uri->getSegment($uri->getTotalSegments()) != 1) {
			 $segment = $uri->getTotalSegments() + 1;
		 } else {
			 $segment = $uri->getTotalSegments();
		 }

		$elements = $this->searchElements($page, $segment, false);
		$data['elements'] = $elements['elements'];
		$data['pager'] = $elements['pager'];

		$data['javascript'] = [
			'App\Modules\Users\Views\admin\subscriptions_js',
			'App\Views\template\modals',
		];

		$data['page'] = $page;
		$data['id'] = '';

		append_array_to_array($data, $this->viewData);

		if ($this->request->isAJAX()) {

			$data['isAjaxRequest'] = true;

			return view('App\Modules\Users\Views\admin\subscriptions_list_ajax', $data);
		}

		$data['isAjaxRequest'] = true;

		return view('template/admin', $data);
	}

	/**
	 * Display list of found elements using AJAX
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
			'name' => $searchText,
			'email' => $searchText,
			'phone' => $searchText,
		];

		if (strtotime($searchText) > 0) {
			$searchArray["FROM_UNIXTIME(`created_at`, '%d.%m.%Y')"] = $searchText;
		}

		$activeOptions = [
			1 => lang('AdminPanel.active'),
			0 => lang('AdminPanel.inactive'),
		];

		if (array_search($searchText, $activeOptions, true) !== false) {
			$searchArray['active'] = array_search($searchText, $activeOptions, true);
		}

		$data = $this->viewData;
		$data['deleted'] = '';
		$data['page'] = $page;

		$data['isAjaxRequest'] = true;

		$uri = service('uri');
		 if ($page == 1 && $uri->getSegment($uri->getTotalSegments()) != 1) {
			 $segment = $uri->getTotalSegments() + 1;
		 } else {
			 $segment = $uri->getTotalSegments();
		 }

		$elements = $this->searchElements($page, $segment, $searchArray);
		$data['elements'] = $elements['elements'];
		$data['pager'] = $elements['pager'];

		$data['lastEdidtedId'] = $this->session->getFlashdata('lastEdidtedId');
		$this->session->setFlashdata('lastEdidtedId', $data['lastEdidtedId']);

		return view('App\Modules\Users\Views\admin\subscriptions_list_ajax', $data);
	}

	/**
	 * Gets the element data to edit in a form
	 *
	 * @param  mixed $id - element id
	 *
	 * @return mixed
	 */
	public function form($id)
	{
		helper('form');

		$data = $this->subscriptionsModel->asArray()->find($id);
		$data['pageTitle'] = lang('SubscriptionsLang.edit');

		$data['lastEdidtedId'] = $this->session->getFlashdata('lastEdidtedId');
		$this->session->setFlashdata('lastEdidtedId', $data['lastEdidtedId']);
		if ($data == null) {
			return json_encode(['status' => 'error', 'data' => $data, 'error_message' => lang('SubscriptionsLang.notFound')]);
		}

		append_array_to_array($data, $this->viewData);

		$data['validationRulesPrimary'] = $this->_getValidationRulesPrimary();
		//$data['validationRulesPrimary'] = [];

		if (!$this->request->isAJAX()) {
			$data['pageTitle'] = lang('SubscriptionsLang.pageTitle');
			$data['isAjaxRequest'] = false;
			$data['view'] = 'App\Modules\Users\Views\admin\subscriptions_list';
			$data['javascript'] = [
				'App\Modules\Users\Views\admin\subscriptions_js',
				'App\Views\template\modals',
			];

			$data['deleted'] = '';
			$data['page'] = 1;

			$uri = service('uri');
			if ($data['page'] == 1 && $uri->getSegment($uri->getTotalSegments()) != 1) {
				$segment = $uri->getTotalSegments() + 1;
			} else {
				$segment = $uri->getTotalSegments();
			}

			$elements = $this->searchElements(1, $segment, false);
			$data['elements'] = $elements['elements'];
			$data['pager'] = $elements['pager'];

			return view('template/admin', $data);
		}

		$data['isAjaxRequest'] = true;

		$data['form_js'] = [
			//'App\Views\template\ckeditor_js',
			//'App\Modules\Users\Views\admin\date_time_picker_js',
			//'App\Modules\Common\ImageMultiUpload\Views\images_multiupload_js',
			//'App\Modules\Common\ImageMultiUpload\Views\images_multiupload_sortable_js',
		];

		$data['id'] = $id;

		$data['view'] = view('App\Modules\Users\Views\admin\subscriptions_form', $data);

		return json_encode(['status' => 'success', 'data' => $data]);
	}

	/**
	 * Processes the form data
	 *
	 * @param  mixed $id - element id
	 * 
	 * @return json
	 */
	public function form_submit($id = 'new')
	{
		if ($this->request->getMethod() === 'post') {
			$save = $this->request->getPost('subscriptions');
			$save['id'] = $id;

			$lastInsertId = $this->subscriptionsModel->saveSubscribtion($save);

			if ($lastInsertId !== false) {
				$data = [
					'id' => $lastInsertId,
					'message' => lang('SubscriptionsLang.saved', [$save['email']]),
				];

				$this->session->setFlashdata('lastEditedId', $lastInsertId);

				return json_encode(['status' => 'success', 'data' => $data]);
			} else {
				$data = [
					'id' => $id,
					'error_message' => $this->subscriptionsModel->errors(),
				];

				return json_encode(['status' => 'error', 'data' => $data]);
			}
		}

		return json_encode(['status' => 'error', 'data' => []]);
	}

	private function _getValidationRulesPrimary(): array
	{
		$validationRules = $this->subscriptionsModel->getValidationRules();
		$returnValidationRules = [];
		foreach ($validationRules as $key => $value) {

			$vRulesArray = explode('|', $value['rules']);

			foreach ($vRulesArray as $vRulesElement) {
				$returnValidationRules[$key . '-' . $vRulesElement] = $vRulesElement;
			}
		}

		return $returnValidationRules;
	}

	/**
	 * Search over elements
	 *
	 * @param  int $page - pagination
	 * @param  int $segment - segment
	 * @param  array $searchArray 
	 *
	 * @return array
	 */
	public function searchElements(int $page = 0, int $segment = 4, $searchArray = []): array
	{
		$_elements = $this->subscriptionsModel->searchElements($searchArray)->paginate($this->viewData['config']->elementsPerPage, 'group', $page, $segment);

		$_pager = $this->subscriptionsModel->pager;

		$returnArray['elements'] = $_elements;
		$returnArray['pager'] = $_pager;

		return $returnArray;
	}

	/**
	 * Sends a subscription email with the new coupon details to the customer.
	 *
	 * @param array $subscriptionData An array containing the subscription data (email, name, token...). Expected to have keys 'email' and 'token'.
	 * @param string|null $emailTitle The title of the email. If null, it will fetch the default title from shop settings.
	 * @param string|null $emailContent The content of the email. If null, it will fetch the default content from shop settings.
	 * @param \App\Modules\ShopSettings\Models\ShopSettingsModel|null $shopSettingsModel An optional instance of the ShopSettingsModel. If not provided, a new instance will be created.
	 *
	 * @return bool True if the email was successfully sent, False otherwise.
	 */
	public function sendSubcriptionEmail($subscriptionData, $emailTitle = null, $emailContent = null, $shopSettingsModel = null)
	{
		helper('email');

		$locale = service('request')->getLocale();
		$shopSettingsModel = $shopSettingsModel ?? new \App\Modules\ShopSettings\Models\ShopSettingsModel;

		$fromEmail = $shopSettingsModel->getElement('email_from_subscribe', $locale)->setup_value ?? '';
		$fromName = $shopSettingsModel->getElement('name_from_subscribe', $locale)->setup_value ?? '';
		$emailTitle = $emailTitle ?? $shopSettingsModel->getElement('subject_subscribe', $locale)->setup_value;
		$emailContent = $emailContent ?? $shopSettingsModel->getElement('content_subscribe', $locale)->setup_value;

		$emailContent = str_replace('{{unsubscribe}}', base_url('/users/unsubscribe/' . $subscriptionData['token']), $emailContent);

		$emailProperties = [
			'to' => $subscriptionData['email'],
			'from' => $fromEmail,
			'from_name' => $fromName,
			'subject' => $emailTitle,
			'content' => $emailContent,
		];

		return send_html_email($emailProperties);
	}

	/**
	 * Sends a coupon email with the new coupon details to the customer.
	 *
	 * @param array|false $newCoupon An array containing the coupon details. Expected to have keys 'code', 'reduction_amount', and 'reduction_type'. If is false, the code will not be included in the email
	 * @param string $customerEmail The email address of the customer.
	 * @param string|null $emailTitle The title of the email. If null, it will fetch the default title from shop settings.
	 * @param string|null $emailContent The content of the email. If null, it will fetch the default content from shop settings.
	 * @param \App\Modules\ShopSettings\Models\ShopSettingsModel|null $shopSettingsModel An optional instance of the ShopSettingsModel. If not provided, a new instance will be created.
	 *
	 * @return bool True if the email was successfully sent, False otherwise.
	 */
	public function sendCouponEmail($newCoupon = false, $customerEmail, $emailTitle = null, $emailContent = null, $shopSettingsModel = null)
	{
		helper('email');

		$locale = service('request')->getLocale();
		$shopSettingsModel = $shopSettingsModel ?? new \App\Modules\ShopSettings\Models\ShopSettingsModel;

		$fromEmail = $shopSettingsModel->getElement('email_from_subscribe', $locale)->setup_value ?? '';
		$fromName = $shopSettingsModel->getElement('name_from_subscribe', $locale)->setup_value ?? '';
		$emailTitle = $emailTitle ?? $shopSettingsModel->getElement('subject_promocode', $locale)->setup_value;
		$emailContent = $emailContent ?? $shopSettingsModel->getElement('content_promocode', $locale)->setup_value;

		if ($newCoupon != false) {
			$emailContent = str_replace('{{promocode}}', lang('CouponsLang.promocode_email_text', [$newCoupon['code'],  $newCoupon['reduction_amount'], lang('CouponsLang.' . $newCoupon['reduction_type'] . '_short')]), $emailContent);
		}

		$emailProperties = [
			'to' => $customerEmail,
			'from' => $fromEmail,
			'from_name' => $fromName,
			'subject' => $emailTitle,
			'content' => $emailContent,
		];

		return send_html_email($emailProperties);
	}

	/**
	 * Sends subscription emails
	 */
	public function sendSubscriptionEmails()
	{
		$this->articlesModel = new \App\Modules\Articles\Models\ArticlesModel;

		$articleId = $this->request->getPost('articleId');

		$article = $this->articlesModel->getArticleLangRowBySiteLanguage($articleId);
		$subscriptions = $this->subscriptionsModel->getSubscriptionsByArticleId($articleId);
		$emailContent = $article->email_html;
		$emailTitle = $article->email_title;

		foreach ($subscriptions as $subscription) {
			$customerEmail = $subscription->email;
			$subscriptionToken = $subscription->token;

			$emailContent = str_replace('{{unsubscribe}}', base_url('/users/unsubscribe/' . $subscriptionToken), $emailContent);

			$result = $this->sendSubcriptionEmail($customerEmail, $emailTitle, $emailContent);

			if ($result) {
				$this->subscriptionsModel->updateSubscriptionSentFlag($subscription->id);
			}
		}

		return json_encode(
			array(
				'success' => true
			)
		);
	}

	/**
	 * Generate subscription token
	 */
	public function generateSubscriptionToken()
	{
		helper('text_helper');

		$token = random_string_pool(32, 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789');

		return $token;
	}

	/**
	 * Subscribe customer
	 */
	public function attemptSubscription($subscriptionData)
	{
		if (empty($subscriptionData['email'])) {
			return ['success' => false];
		}

		$subscription = $this->subscriptionsModel->where(['email' => $subscriptionData['email'], 'active' => 1])->first();
		if ($subscription != null) {
			return [
				'success' => false,
				'errors' => ['errors' => [lang('SubscriptionsLang.subscriptionAlreadyExists')]],
			];
		}

		$subscription = $this->subscriptionsModel->where('email', $subscriptionData['email'])->first();

		// If the record doesn't exist, generate a new token and set the ID to false.
		if (!$subscription) {
			$subscriptionData['id'] = false;
			$subscriptionData['token'] = $this->generateSubscriptionToken();
		}

		// If a subscription exists, update it; otherwise, insert a new one.
		$operationResult = $subscription ?
			$this->subscriptionsModel->update($subscription->id, $subscriptionData) :
			$this->subscriptionsModel->insert($subscriptionData, true);

		// Check if the database operation succeeded.
		if ($operationResult === false) {
			return [
				'success' => false,
				'errors' => ['errors' => $this->subscriptionsModel->errors()]
			];
		}

		// If a subscription not exists, generate a new coupon if not empty settings string.
		$locale = service('request')->getLocale();
		$shopSettingsModel = new \App\Modules\ShopSettings\Models\ShopSettingsModel;

		$promocodeSettings = $shopSettingsModel->getElement('promocode', $locale)->setup_value ?? '';

		if (!$subscription) {

			$this->sendSubcriptionEmail($subscriptionData, $emailTitle = null, $emailContent = null, $shopSettingsModel);

			if ($promocodeSettings != '') {
				$newCouponProcess = $this->_createCoupon($subscriptionData['email'], null, $shopSettingsModel);

				if ($newCouponProcess['success']) {
					$this->sendCouponEmail($newCouponProcess['coupon'], $subscriptionData['email'], $emailTitle = null, $emailContent = null, $shopSettingsModel);
				}
			}
		}

		return ['success' => true];
	}

	private function _updateSubscriptionSession()
	{
		// Retrieve the current 'userData' session data
		$userData = session()->get('userData');

		// Check if 'userData' is an array and contains the 'subscription' key
		//if (is_array($userData) && isset($userData['subscription'])) {
			// Update the 'subscription' value
			$userData['subscription'] = 1;

			// Set the updated array back into the session
			session()->set('userData', $userData);
		//}
	}

	public function emailSubscribe() 
	{
		if (!$this->request->isAJAX()) {
			return json_encode(['error' => true]);
		}

		$settingsModel = new \App\Modules\Settings\Models\SettingsModel;

		$postData = $this->request->getPost(null, FILTER_SANITIZE_STRING);

		// Define validation rules
		$validationRules = [
			'email' => [
				'label' => 'SubscriptionsLang.email',
				'rules' => 'required|valid_email',
			],
			'warn' => [
				'label' => $settingsModel->getElement('subs-2', $this->viewData['locale'])->setup_value,
				'rules' => 'required',
			],
		];

		// Run validation
		if (!$this->validate($validationRules)) {
			return json_encode([
				'status' => 'error',
				'message' => $this->validator->getErrors(),
			]);
		}

		// Process the subscription if email is valid
		if (isset($postData['email'])) {
			$subscribeData = [
				'email' => $postData['email'],
				'active' => 1,
				'name' => '',
				'phone' => '',
			];

			$statusAttemptSubscription = $this->attemptSubscription($subscribeData);

			if ($statusAttemptSubscription['success'] == true) {

				$this->_updateSubscriptionSession();

				return json_encode([
					'status' => 'success',
				]);
			}

			if ($statusAttemptSubscription['success'] == false) {
				return json_encode([
					'status' => 'error',
					'message' => $statusAttemptSubscription['errors']['errors'],
				]);
			}
		}
	}

	/**
	 * Generate a coupon promocode and return an array with promocode data.
	 * 
	 * @param string $email The email associated with the coupon.
	 * @param \App\Modules\Coupons\Models\CouponsModel|null $couponsModel An optional instance of the CouponsModel. If not provided, a new instance will be created.
	 * @param \App\Modules\ShopSettings\Models\ShopSettingsModel|null $shopSettingsModel An optional instance of the ShopSettingsModel. If not provided, a new instance will be created.
	 * 
	 * @return array The resulting array will contain a 'success' key which indicates whether the coupon creation was successful or not. 
	 *               If successful, the array will also contain a 'coupon' key with the coupon data.
	 *               If failed, the array will contain an 'errors' key with the related errors.
	 */
	private function _createCoupon($email, $couponsModel = null, $shopSettingsModel = null)
	{
		$locale = service('request')->getLocale();

		// Use the provided models or instantiate them if they are null.
		$couponsModel = $couponsModel ?? new \App\Modules\Coupons\Models\CouponsModel;
		$shopSettingsModel = $shopSettingsModel ?? new \App\Modules\ShopSettings\Models\ShopSettingsModel;

		$promocodeSettings = $shopSettingsModel->getElement('promocode', $locale)->setup_value ?? '|';
		$promocodeSettingsArray = explode('|', $promocodeSettings);

		$couponData = [
			'id' => false,
			'code' => $this->_randomCouponCode(),
			'name' => $email,
			'start_date' => null,
			'end_date' => null,
			'whole_order_coupon' => 1,
			'max_uses' => 1,
			'reduction_type' => $promocodeSettingsArray[1] ?? '',
			'reduction_amount' => (float)$promocodeSettingsArray[0] ?? '',
		];

		if ($couponsModel->saveCoupon($couponData)) {
			return [
				'success' => true,
				'coupon' => $couponData
			];
		}

		return [
			'success' => false,
			'errors' => ['errors' => $couponsModel->errors()]
		];
	}

	/**
	 * Generate a random coupon promocode.
	 * @return string
	 */
	private function _randomCouponCode()
	{
		helper('text_helper');

		return random_string_pool(8, 'ABCDEFGHJKLMNPRSTUVWXYZ34568');
	}

	/**
	 * Unsubscribe a customer
	 *
	 * @param string $token The subscription token.
	 * @return View The view for the unsubscription process.
	 */
	public function attemptUnsubscription($token)
	{
		$data = [
			'view' => 'App\Modules\Users\Views\unsubscription',
			'locale' => service('request')->getLocale(),
		];

		$subscriptionToDeactivate = $this->subscriptionsModel->getSubscriptionByToken($token);

		if ($subscriptionToDeactivate) {
			$subscriptionToDeactivate->active = 0;

			if ($this->subscriptionsModel->save($subscriptionToDeactivate)) {
				// Successfully updated the record
				$data['message'] = lang('SubscriptionsLang.unsubscriptionSuccess');
			} else {
				// Failed to update the record
				$data['error'] = lang('SubscriptionsLang.unsubscriptionError');
			}
		} else {
			$data['error'] = lang('SubscriptionsLang.unsubscriptionNotFound');
		}

		return view('template/layout', $data);
	}
}