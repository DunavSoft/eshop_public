<?php
namespace App\Modules\Pages\Controllers;

/**
 * Class BaseController
 *
 * BaseController provides a convenient place for loading components
 * and performing functions that are needed by all your controllers.
 * Extend this class in any new controllers:
 *     class Home extends BaseController
 *
 * For security be sure to declare any new methods as protected or private.
 *
 * @package CodeIgniter
 */

use CodeIgniter\Controller;

class BaseController extends Controller
{

	/**
	 * An array of helpers to be loaded automatically upon
	 * class instantiation. These helpers will be available
	 * to all other controllers that extend BaseController.
	 *
	 * @var array
	 */
	protected $session;
	protected $helpers = [];
	protected $viewData = [];

	/**
	 * Constructor.
	 */
	public function initController(\CodeIgniter\HTTP\RequestInterface $request, \CodeIgniter\HTTP\ResponseInterface $response, \Psr\Log\LoggerInterface $logger)
	{
		// Do Not Edit This Line
		parent::initController($request, $response, $logger);

		//--------------------------------------------------------------------
		// Preload any models, libraries, etc, here.
		//--------------------------------------------------------------------
		// E.g.:
		$this->session = \Config\Services::session();
		
		$this->viewData['active_page'] = 'pages';
		
		$this->viewData['locale'] = $request->getLocale();
        $this->viewData['supportedLocales'] = $request->config->supportedLocales;
		
        $this->viewData['languagesAdmin'] = $this->languagesModel->getActiveElements('admin');
        $this->viewData['languagesSite'] = $this->languagesModel->getActiveElements('site');
		
        $this->viewData['error'] = $this->session->getFlashdata('error');
        $this->viewData['message'] = $this->session->getFlashdata('message');
        $this->viewData['warning'] = $this->session->getFlashdata('warning');
		
		$this->viewData['activeMenu'] = 'pages';
		$this->viewData['useSearch'] = true;
	}
}