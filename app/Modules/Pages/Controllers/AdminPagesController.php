<?php

/**
 * @package Pages
 * @author Georgi Nechovski
 * @copyright 2024 Dunav Soft Ltd
 * @version 2.0.0.0
 */

namespace App\Modules\Pages\Controllers;

use App\Libraries\Slug;
use App\Libraries\ImagesConvert;

use App\Modules\Routes\Models\RoutesModel;

class AdminPagesController extends BaseController
{
    protected $session;
    protected $pagesModel;
    protected $routeModel;
    protected $languagesModel;
    protected $pagesLanguagesModel;
    protected $useLog;
    protected $logModel;
    protected $config;
    protected $locale;
    protected $db;

    /**
     * Constructor.
     */
    public function __construct()
    {
        $this->session = \Config\Services::session();

        $this->config = new \Config\App();

        $this->db = \Config\Database::connect();

        $this->locale = service('request')->getLocale();

        $this->useLog = false;

        $this->pagesModel = new \App\Modules\Pages\Models\PagesModel;

        $this->routeModel = new RoutesModel();

        if ($this->useLog) {
            $this->logModel = model('App\Modules\Pages\Models\logModel', false);
        }

        $this->languagesModel = new \App\Modules\Languages\Models\LanguagesModel;

        $this->pagesLanguagesModel = new \App\Modules\Pages\Models\PagesLanguagesModel;
    }

    public function index(int $page = 1, $deleted = 0)
    {
        helper('form');

		$uri = service('uri');
		if ($page == 1 && $uri->getSegment($uri->getTotalSegments()) != 1) {
			$segment = $uri->getTotalSegments() + 1;
		} else {
			$segment = $uri->getTotalSegments();
		}

		$elements = $this->getPages($deleted, [], $page, $segment);

        $data = [
			'view' => 'App\Modules\Pages\Views\admin\admin_pages_index',
			'ajax_view' => 'App\Modules\Pages\Views\admin\admin_pages_index_ajax',
			'lastEdidtedId' => $this->session->getFlashdata('lastEdidtedId'),
			'pageTitle' => (($deleted != false) ? lang('AdminPagesLang.pageTitle') . lang('AdminPanel.whichDeleted') : lang('AdminPagesLang.pageTitle')),
			'page' => $page,
			'id' => '',
			'locale' => $this->locale,
			'pages' => $elements['elements'],
			'pager' => $elements['pager'],
			'deleted' => $deleted,
			'javascript' => ['App\Modules\Pages\Views\admin\admin_pages_js', 'App\Views\template\modals',],
		];

		$data['uriWarningLength'] = $this->config->uriWarningLength;

		$data['languages'] = $this->languagesModel->getActiveElements('site');

		$data['isAjaxRequest'] = true;

		$this->session->setFlashdata('lastEdidtedId', $data['lastEdidtedId']);

		append_array_to_array($data, $this->viewData);

		if ($this->request->isAJAX()) {

			$data['is_ajax'] = true;

			return view('App\Modules\Pages\Views\admin\admin_pages_index_ajax', $data);
		}

		$data['duplicate'] = false;

		return view('template/admin', $data);
    }

    public function getPages($deleted, array $filterData = [], int $page = 1, $segment = 4) : array
	{
		$_pages = [];

		$data['config'] = config('App\Modules\Pages\Config\Pages', false);

		$this->pagesModel->getElements($deleted, $filterData);

		if ($deleted != false) {
			$elements = $this->pagesModel->onlyDeleted()->paginate($data['config']->elementsPerPage, 'group', $page, $segment);
		} else {
			$elements = $this->pagesModel->paginate($data['config']->elementsPerPage, 'group', $page, $segment);
		}

		$pager = $this->pagesModel->pager;

		foreach ($elements as &$element) {
			$element->title = $this->_getPageDefaultTitle($element->id);
		}

		$_pages['elements'] = $elements;
		$_pages['pager'] = $pager;
		
		return $_pages;
	}

    // This function is used in menus controller
    public function get_pages($deleted = 0)
    {
        $_pages = $this->pagesModel->getPages($deleted);

        foreach ($_pages as &$element) {
            $element->title = $this->_getPageDefaultTitle($element->id);
        }

        return $_pages;
    }

    /**
	 * Display list of found elements using AJAX
	 *
	 * @param  int $page - to display page
	 *
	 * @return void
	 */

	public function search(int $page = 1, $deleted = 0)
	{
		$searchText = $this->request->getPost('top-search-text');

		if ($searchText == '' && $page >= 1) {
			$searchText = $this->session->get('searchText');
			$this->session->set('searchText', $searchText);
		} else {
			$this->session->set('searchText', $searchText);
		}

		$searchArray = [];
		if ($searchText != '') {
			$searchArray = [
				'pages_languages.title' => $searchText,
			];
		}

		$activeOptions = [
			1 => lang('AdminPanel.active'),
			0 => lang('AdminPanel.inactive'),
		];

		if (array_search($searchText, $activeOptions, true) !== false) {
			$searchArray['pages.active'] = array_search($searchText, $activeOptions, true);
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

		$elements = $this->getPages($deleted, $searchArray, $page, $segment);
		$data['pages'] = $elements['elements'];
		$data['pager'] = $elements['pager'];

		$data['locale'] = $this->locale;

		$data['is_ajax'] = true;

		$data['lastEdidtedId'] = $this->session->getFlashdata('lastEdidtedId');
		$this->session->setFlashdata('lastEdidtedId', $data['lastEdidtedId']);

		return view('App\Modules\Pages\Views\admin\admin_pages_index_ajax', $data);
	}

    public function form($id = 'new', $duplicate = false)
    {
        helper('form');

        if ($id !== 'new') {

			$data['pageTitle'] = lang('AdminPagesLang.edit');

			$page = $this->pagesModel->getPageById($id);

			if ($page == null) {
				return json_encode(['status' => 'error', 'data' => $data, 'error_message' => lang('AdminPagesLang.notFound')]);
			}

			foreach ($page as $key => $value) {
				$data[$key] = $value;
			}

		} else {
			$this->_getFieldNames($data);

			$data['pageTitle'] = lang('AdminPagesLang.add');
		}

        append_array_to_array($data, $this->viewData);

		$data['duplicate'] = $duplicate;

        if (!$this->request->isAJAX()) {
			$data['pageTitle'] = lang('AdminPagesLang.pageTitle');
			$data['isAjaxRequest'] = false;
			$data['locale'] = $this->locale;
			$data['uriWarningLength'] = $this->config->uriWarningLength;
			$data['languages'] = $this->languagesModel->getActiveElements('site');
			$data['view'] = 'App\Modules\Pages\Views\admin\admin_pages_index';
			$data['ajax_view'] = 'App\Modules\Pages\Views\admin\admin_pages_index_ajax';
			$data['javascript'] = [ 
				'App\Modules\Pages\Views\admin\admin_pages_js',
				'App\Views\template\modals',
			];	
			$data['lastEdidtedId'] = $this->session->getFlashdata('lastEdidtedId');
			$this->session->setFlashdata('lastEdidtedId', $data['lastEdidtedId']);

			$elements = $this->getPages(false, [], 1);
			$data['pages'] = $elements['elements'];
			$data['pager'] = $elements['pager'];
			
			$data['deleted'] = 0;
			$data['page'] = 1;
			
			return view('template/admin', $data);
		}

        $data['isAjaxRequest'] = true;

        $data['pagesLanguages'] = [];

        if ($id !== 'new') {
            $pagesLanguages = $this->pagesModel->getPagesLanguages($id);

            foreach ($pagesLanguages as $pageLang) {
                $pageLang->slug = '';

                if (!empty($pageLang->route_id)) {
                    $route = $this->routeModel->find($pageLang->route_id);
                    $pageLang->slug = $route->slug ?? '';
                }

                $data['pagesLanguages'][$pageLang->lang_id] = $pageLang;
            }
        }

        $data['languages'] = $this->languagesModel->getActiveElements('site');

        $data['uriWarningLength'] = $this->config->uriWarningLength;

        $data['form_js'] = [
			'App\Views\template\ckeditor_js',
        ];

        $data['id'] = $id;
        
        if ($duplicate !== false) {
            $data['id']	= 'new';
            $data['pageTitle'] = lang('AdminPagesLang.copy');
        }

        $data['view'] = view('App\Modules\Pages\Views\admin\admin_pages_form', $data);
		
		return json_encode(['status' => 'success', 'data' => $data]);
    }

    public function form_submit($id = 'new')
    {
        if ($this->request->getMethod() === 'post') {

            $save = $this->request->getPost('pages');
            $savePagesLanguages = $this->request->getPost('pages_languages');

            if ($id !== 'new') {
                $save['id'] = $id;
            } else {
                $save['id'] = false;
            }

            $this->db->transStart(); //Begin Transaction

            $lastInsertId = $this->pagesModel->savePage($save);

            if ($lastInsertId != false) {

                $savePL = [];
                $slugLenghtWarning = false;
                $slugOverLenghtArray = [];

                $data['id'] = $lastInsertId;

                $slugData = [];

                foreach ($savePagesLanguages as $key => $savePL) {

                    //savePagesLanguages
                    $savePL['lang_id'] = $key;
                    $savePL['page_id'] = $lastInsertId;

                    if ($savePL['slug'] == '') {
                        $savePL['slug'] = $savePL['title'];
                    }

                    if ($savePL['id'] == '') {
                        $savePL['id'] = false;
                    }

                    // Retrieve existing route_id if not already present
                    if (empty($savePL['route_id'])) {
                        $existingPageLang = $this->pagesLanguagesModel
                        ->where('id', $savePL['id'])
                            ->first();

                        $savePL['route_id'] = $existingPageLang->route_id ?? null;
                    }

                    // create a new Slug object
                    $slug = new Slug([
                        'title' => $savePL['title'],
                        'table' => 'pages_languages',
                    ]);

                    $savePL['slug'] = $slug->create_uri($savePL, $savePL['id']);

                    if (strlen(site_url($savePL['slug'])) > $this->config->uriWarningLength) {
                        $slugLenghtWarning = true;
                        $slugOverLenghtArray[] = site_url($savePL['slug']);
                    }

                    if (empty($savePL['route_id'])) {
                        $routeData = [
                            'slug' => $savePL['slug'],
                            'route' => '/pages/controllers/pagesController::view',
                        ];
                        $savePL['route_id'] = $this->routeModel->insert($routeData, true);
                    } else {
                        $this->routeModel->update($savePL['route_id'], [
                            'slug' => $savePL['slug'],
                            'route' => '/pages/controllers/pagesController::view',
                        ]);
                    }

                    $lastInsertPagesLanguagesId = $this->pagesLanguagesModel->savePagesLanguages($savePL);

                    if ($lastInsertPagesLanguagesId == false) {

                        if ($id === 'new') {
                            $data['id'] = 'new';
                        }

                        $data['error_message'] = $this->pagesLanguagesModel->errors();

                        return json_encode(['status' => 'error', 'data' => $data]);
                    }

                    $slugData[$key] = $savePL['slug'];
                }

                $this->db->transComplete(); //End Transaction

                if ($this->db->transStatus() === true) {
                    $data['message'] = lang('AdminPagesLang.pageSaved', [$this->_getPageDefaultTitle($lastInsertId)]);
                    $data['slugs'] = $slugData;

                    if ($slugLenghtWarning) {
                        $this->session->setFlashdata('warning', lang('AdminPanel.slugLenghtWarning', $slugOverLenghtArray));
                    }

                    // log
                    if ($this->useLog) {
                        $this->_saveLog($lastInsertId, $save);
                    }

                    //save images as files
                    $imagesConvert = new ImagesConvert();

                    $imagesConvert->convertImage(['pages'], ['pages' => 'image']);
                    $imagesConvert->convertImage(['pages'], ['pages' => 'image_responsive']);
                }

                $this->session->setFlashdata('lastEdidtedId', $lastInsertId);

            } else {

                $data['id'] = $id;

                $data['error_message'] = $this->pagesModel->errors();

                return json_encode(['status' => 'error', 'data' => $data]);
            }

            return json_encode(['status' => 'success', 'data' => $data]);
        }

        return json_encode(['status' => 'error', 'data' => []]);
    }

    public function delete($id)
	{
		if ((int)$id == 0) {
			$data['error_message'] = lang('AdminPagesLang.notFound');
			return json_encode(['status' => 'error', 'data' => $data]);
		}

		$element = $this->pagesModel->find($id);

		if ($element == null) {
			$data['error_message'] = lang('AdminPagesLang.notFound');
			return json_encode(['status' => 'error', 'data' => $data]);
		}

		$deleted = $this->pagesModel->delete($id);

		$deleted = $this->pagesLanguagesModel->delete($id);

		if ($deleted !== false) {
			$data['message'] = lang('AdminPagesLang.pageDeleted', [$this->_getPageDefaultTitle($element->id)]);
			$data['id'] = $id;
			return json_encode(['status' => 'success', 'data' => $data]);
		} else {
			$data['error_message'] = $this->pagesModel->errors();
			return json_encode(['status' => 'error', 'data' => $data]);
		}
	}

	public function restore($id)
	{
		if ((int)$id == 0) {
			$data['error_message'] = lang('AdminPagesLang.notFound');
			return json_encode(['status' => 'error', 'data' => $data]);
		}

		$element = $this->pagesModel->onlyDeleted()->find($id);

		if ($element == null) {
			$data['error_message'] = lang('AdminPagesLang.notFound');
			return json_encode(['status' => 'error', 'data' => $data]);
		}

		$restored = $this->pagesModel->restore($id);

		if ($restored !== false) {
			$data['message'] = lang('AdminPagesLang.pageRestored', [$this->_getPageDefaultTitle($element->id)]);
			$data['id'] = $id;
			return json_encode(['status' => 'success', 'data' => $data]);
		} else {
			$data['error_message'] = $this->pagesModel->errors();
			return json_encode(['status' => 'error', 'data' => $data]);
		}
	}

    private function _getFieldNames(&$data)
    {
        $field_data_array = $this->pagesModel->getFieldData();

        foreach ($field_data_array as $field) {
            $data[$field->name] = $field->default;
        }
    }

    private function _getPageDefaultTitle($id)
    {
        $element = $this->pagesModel->getPageLangRowBySiteLanguage($id);

        if ($element == null) {
            return '';
        }

        return $element->title;
    }

    private function _saveLog($page_id, $save, $deleteAction = false)
    {
        $saveLog = [];
        $saveLog['page_id'] = $page_id;
        $saveLog['content'] = serialize($save);
        $saveLog['user_id'] = 1; //TODO

        if ($save['id'] == false && $deleteAction == false) {
            $saveLog['action'] = 'created';
        }
        if ($save['id'] != false && $deleteAction == false) {
            $saveLog['action'] = 'edited';
        }
        if ($deleteAction === true) {
            $saveLog['action'] = 'deleted';
        }

        $this->logModel->insert($saveLog);
    }
}