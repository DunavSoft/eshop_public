<?php

/**
 * @version 1.0.0.0
 * @author Georgi Nechovski
 */

namespace App\Modules\Galleries\Controllers;

use App\Libraries\Slug;
use App\Libraries\ImagesConvert;

use App\Modules\Routes\Models\RoutesModel;

class GalleriesController extends BaseController
{
	protected $galleriesModel;
	protected $galleriesLanguagesModel;
	protected $languagesModel;
	protected $galleriesImagesModel;
	protected $config;
	protected $db;

	/**
	 * Constructor.
	 */
	public function __construct()
	{
		$this->config = new \Config\App();

		$this->galleriesModel = new \App\Modules\Galleries\Models\GalleriesModel;
		$this->galleriesLanguagesModel = new \App\Modules\Galleries\Models\GalleriesLanguagesModel;
		$this->languagesModel = new \App\Modules\Languages\Models\LanguagesModel;
		$this->galleriesImagesModel = new \App\Modules\Galleries\Models\GalleriesImagesModel;
	}

	public function index($deleted = 0)
	{
		$data = $this->viewData;

		if ($deleted != false) {
			$data['pageTitle'] = lang('GalleriesLang.galleries') . lang('AdminPanel.whichDeleted');
		} else {
			$data['pageTitle'] = lang('GalleriesLang.galleries');
		}

		$data['view'] = 'App\Modules\Galleries\Views\admin\galleries_index';
		$data['elements'] = $this->get_galleries($deleted);
		$data['are_you_sure'] = 'App\Views\template\are_you_sure';
		$data['deleted'] = $deleted;

		$ImagesConvert = new ImagesConvert();
		$ImagesConvert->convertImage();

		return view('template/admin', $data);
	}

	public function get_galleries($deleted = 0, $activeOnly = false)
	{
		$_elements = $this->galleriesModel->getGalleries($deleted, $activeOnly);

		foreach ($_elements as &$element) {
			$element->title = $this->_getGalleryDefaultTitle($element->id);
		}

		return $_elements;
	}

	public function form($id = 'new', $duplicate = false)
	{
		helper('form');
		helper('text');

		// create a new Slug object
		$slug = new Slug([
			'title' => 'title',
			'table' => 'galleries_languages',
		]);

		if ($id !== 'new') {
			$data = $this->galleriesModel->asArray()->find($id);

			if ($data == null) {
				$this->session->setFlashdata('error', lang('GalleriesLang.notFound'));
				return redirect()->to('/admin/galleries');
			}

			$data['pageTitle'] = lang('GalleriesLang.edit');
		} else {
			$data = $this->getFieldNames();

			$data['pageTitle'] = lang('GalleriesLang.add');
		}

		$data['config'] = config('App\Modules\Galleries\Config\Galleries', false);

		$data['view'] = 'App\Modules\Galleries\Views\admin\galleries_form';
		$data['javascript'] = ['App\Modules\Galleries\Views\admin\form_js', 'App\Modules\Galleries\Views\admin\ordering_js'];

		append_array_to_array($data, $this->viewData);

		$data['languages'] = $this->languagesModel->getActiveElements('site');

		$data['galleries_images'] = $this->galleriesImagesModel->getImagesByGalleryId($id);
		$imagesRemoveArray = [];
		foreach ($data['galleries_images'] as $element) {
			$imagesRemoveArray[$element->id] = $element->id;
		}

		$routeModel = new RoutesModel();

		$data['galleriesLanguages'] = [];

		if ($id !== 'new') {
			$galleriesLanguages = $this->galleriesModel->getGalleriesLanguages($id);

			foreach ($galleriesLanguages as $langElement) {
				$langElement->slug = '';

                if (!empty($langElement->route_id)) {
                    $route = $routeModel->find($langElement->route_id);
                    $langElement->slug = $route->slug ?? '';
                }

				$data['galleriesLanguages'][$langElement->lang_id] = $langElement;
			}
		}

		$data['id'] = $id;
		if ($duplicate !== false) {
			$data['id']	= 'new';
			$data['pageTitle'] = lang('GalleriesLang.copy');
		}

		if ($this->request->getMethod() === 'post') {

			$this->db = \Config\Database::connect();
			$this->db->transStart(); //Begin Transaction

			//save galleries
			$save = $this->request->getPost('save');

			if ($id !== 'new') {
				$save['id'] = $id;
			} else {
				$save['id'] = false;
			}

			if (!isset($save['show_home'])) {
				$save['show_home'] = 0;
			}
			if (!isset($save['show_list'])) {
				$save['show_list'] = 0;
			}

			$lastInsertId = $this->galleriesModel->saveGallery($save);

			if ($lastInsertId == false) {
				$data['errors'] = $this->galleriesModel->errors();

				$data['galleries_images'] = $this->request->getPost('galleries_images') ?? [];

				return view('template/admin', $data);
			}

			//save galleries_languages
			$saveGalleriesLanguages = $this->request->getPost('galleries_languages');

			$slugLenghtWarning = false;
			$slugOverLenghtArray = [];
			foreach ($saveGalleriesLanguages as $key => $saveLang) {

				$saveLang['lang_id'] = $key;
				$saveLang['gallery_id'] = $lastInsertId;

				if ($saveLang['slug'] == '') {
					$saveLang['slug'] = $saveLang['title'];
				}

				if ($saveLang['id'] == '') {
					$saveLang['id'] = false;
				}

				// Retrieve existing route_id if not already present
                if (empty($saveLang['route_id'])) {
                    $existingGalleryLang = $this->galleriesLanguagesModel
                        ->where('id', $saveLang['id'])
                        ->first();

                    $saveLang['route_id'] = $existingGalleryLang->route_id ?? null;
                }

				$saveLang['slug'] = $slug->create_uri($saveLang, $saveLang['id']);

				//images description for galleries_languages table
				$imagesDescPost = $this->request->getPost('images_desc[' . $key . ']');
				unset($imagesDescPost[0]);

				$imagesDesc = [];
				foreach ($imagesDescPost as $key => $value) {
					$imagesDesc[] = $value;
				}

				$saveLang['images_description'] = json_encode($imagesDesc);

				if (strlen(site_url($saveLang['slug'])) > $this->config->uriWarningLength) {
					$slugLenghtWarning = true;
					$slugOverLenghtArray[] = site_url($saveLang['slug']);
				}

				if (empty($saveLang['route_id'])) {
                    $routeData = [
                        'slug' => $saveLang['slug'],
                        'route' => '/galleries/controllers/galleriesController::viewDetails',
                    ];
                    $saveLang['route_id'] = $routeModel->insert($routeData, true);
                } else {
                    $routeModel->update($saveLang['route_id'], [
                        'slug' => $saveLang['slug'],
                        'route' => '/galleries/controllers/galleriesController::viewDetails',
                    ]);
                }

				$lastInsertGalleriesLanguagesId = $this->galleriesLanguagesModel->saveGalleriesLanguages($saveLang);

				if ($lastInsertGalleriesLanguagesId == false) {
					$data['errors'] = $this->galleriesLanguagesModel->errors();

					foreach ($saveGalleriesLanguages as $key => $value) {
						$data['galleriesLanguages'][$key] = $value;
					}

					$data['galleries_images'] = $this->request->getPost('galleries_images') ?? [];

					return view('template/admin', $data);
				}
			}

			//save images
			$imagesPostArray = $this->request->getPost('galleries_images');

			$sequence = 1;
			if ($imagesPostArray) {

				foreach ($imagesPostArray as $postElement) {

					$saveImg = [];
					$saveImg['id'] = false;
					foreach ($postElement as $key => $value) {
						$saveImg[$key] = $value;
					}

					if ($id == 'new') {
						//COPY content of the image 
						if ($saveImg['id'] != false) {
							$originalImage = $this->galleriesImagesModel->find($saveImg['id']);
							$saveImg['image'] = $originalImage->image;
						}

						unset($imagesRemoveArray[$saveImg['id']]);
						$saveImg['id'] = false;
					}

					$saveImg['gallery_id'] = $lastInsertId;
					$saveImg['sequence'] = $sequence;

					//d($saveImg);exit;

					$this->galleriesImagesModel->save($saveImg);

					$sequence++;

					if ($saveImg['id'] != false) {
						unset($imagesRemoveArray[$saveImg['id']]);
					}
				}
			}

			//remove deleted images
			foreach ($imagesRemoveArray as $key => $value) {
				$this->galleriesImagesModel->where('id', $key)->delete();
			}

			$this->db->transComplete();

			if ($this->db->transStatus() === true) {

				$this->session->setFlashdata('message', lang('GalleriesLang.saved', [
					$this->_getGalleryDefaultTitle($lastInsertId),
					'<a href="' . site_url($data['locale'] . '/admin/galleries/form/' . $lastInsertId) . '">' . lang('GalleriesLang.edit') . '</a>'
				]));

				if ($slugLenghtWarning) {
					$this->session->setFlashdata('warning', lang('AdminPanel.slugLenghtWarning', $slugOverLenghtArray));
				}

				if ($this->request->getPost('submit_save_and_return') !== null) {
					return redirect()->to('/' . $data['locale'] . '/admin/galleries/form/' . $lastInsertId);
				} else {
					return redirect()->to('/' . $data['locale'] . '/admin/galleries');
				}
			}
		}

		return view('template/admin', $data);
	}

	private function getFieldNames()
	{
		$return_array = [];
		$field_data_array = $this->galleriesModel->getFieldData();

		foreach ($field_data_array as $field) {
			$return_array[$field->name] = $field->default;
		}

		return $return_array;
	}

	public function delete($id)
	{
		$locale = $this->viewData['locale'];

		if ((int)$id == 0) {
			$this->session->setFlashdata('error', lang('GalleriesLang.notFound'));
			return redirect()->to('/' . $locale . '/admin/galleries');
		}

		$data = $this->galleriesModel->find($id);
		if ($data == null) {
			$this->session->setFlashdata('error', lang('GalleriesLang.notFound'));
			return redirect()->to('/' . $locale . '/admin/galleries');
		}

		$deleted = $this->galleriesModel->delete($id);

		if ($deleted !== false) {

			$this->session->setFlashdata('message', lang('GalleriesLang.deleted', [
				$this->_getGalleryDefaultTitle($id),
				'<a href="' . site_url('/' . $locale . '/admin/galleries/restore/' . $id) . '">' . lang('GalleriesLang.undoDelete') . '</a>'
			]));

			return redirect()->to('/' . $locale . '/admin/galleries');
		} else {
			$this->session->setFlashdata('error', $this->galleriesModel->errors());
			return redirect()->to('/' . $locale . '/admin/galleries');
		}
	}

	public function restore($id)
	{
		$locale = &$this->viewData['locale'];

		if ((int)$id == 0) {
			$this->session->setFlashdata('error', lang('GalleriesLang.notFound'));
			return redirect()->to('/' . $locale . '/admin/galleries');
		}

		$data = $this->galleriesModel->onlyDeleted()->find($id);
		if ($data == null) {
			$this->session->setFlashdata('error', lang('GalleriesLang.notFound'));
			return redirect()->to('/' . $locale . '/admin/galleries');
		}

		$restored = $this->galleriesModel->restore($id);

		if ($restored !== false) {
			$this->session->setFlashdata('message', lang('GalleriesLang.restored', [$this->_getGalleryDefaultTitle($id)]));
			return redirect()->to('/' . $locale . '/admin/galleries');
		} else {
			$this->session->setFlashdata('error', $this->galleriesModel->errors());
			return redirect()->to('/' . $locale . '/admin/galleries');
		}
	}

	private function _getGalleryDefaultTitle($id): string
	{
		$element = $this->galleriesModel->getGalleryLangRowBySiteLanguage($id);
		if ($element == null) {
			return '';
		}

		return $element->title;
	}

	public function process_ordering($galleryId)
	{
		//save images
		$imagesPostArray = $this->request->getPost('galleries_images');
		$sortingImagesPostArray = $this->request->getPost('sorting_images');

		if ($imagesPostArray) {

			$data['galleries_images'] = $this->galleriesImagesModel->getImagesByGalleryId($galleryId);
			$imagesRemoveArray = [];
			foreach ($data['galleries_images'] as $element) {
				$imagesRemoveArray[$element->id] = $element->id;
			}

			$newIdArray = [];
			$nrImageArray = [];

			$sequence = 1;
			foreach ($imagesPostArray as $postElement) {

				if (isset($sortingImagesPostArray[$sequence])) {
					$nrImageArray[] = $sortingImagesPostArray[$sequence];
				}

				$saveImg = [];
				$saveImg['id'] = false;
				foreach ($postElement as $key => $value) {
					$saveImg[$key] = $value;
				}

				$saveImg['gallery_id'] = $galleryId;
				$saveImg['sequence'] = $sequence;

				$lastInsertId = $this->galleriesImagesModel->saveGalleryImage($saveImg);

				if ($saveImg['id'] == '') {
					$newIdArray[$sortingImagesPostArray[$sequence]] = $lastInsertId;
				}

				$sequence++;

				if ($saveImg['id'] != false) {
					unset($imagesRemoveArray[$saveImg['id']]);
				}
			}

			//remove deleted images
			foreach ($imagesRemoveArray as $key => $value) {
				$this->galleriesImagesModel->where('id', $key)->delete();
			}

			//save galleries_languages
			$saveGalleriesLanguages = $this->request->getPost('galleries_languages');

			foreach ($saveGalleriesLanguages as $key => $saveLang) {

				$saveLang['lang_id'] = $key;
				$saveLang['gallery_id'] = $galleryId;

				if ($saveLang['id'] == '') {
					$saveLang['id'] = false;
				}

				//images description for galleries_languages table
				$imagesDescPost = $this->request->getPost('images_desc[' . $key . ']');
				unset($imagesDescPost[0]);

				$imagesDesc = [];
				foreach ($imagesDescPost as $key => $value) {
					$imagesDesc[] = $value;
				}

				$saveLang['images_description'] = json_encode($imagesDesc);

				$this->galleriesLanguagesModel->saveGalleriesLanguages($saveLang);
			}

			echo json_encode(['success' => 'success', 'newIdArray' => $newIdArray, 'nrImageArray' => $nrImageArray]);
		}
	}

	/**
	 * Function working on Front, shows list of galleries.
	 * Gets page, based on URI. Take notice that we pass URI parameter directly from service('uri').
	 * In this case we dont need to define /page/ in the URL
	 *
	 * @return view('template/layout')
	 */
	public function galleriesList()
	{
		$pager = \Config\Services::pager();
        helper('text');

        $data = [
            'view' => 'App\Modules\Galleries\Views\galleries_list_front',
            'is_details' => false,
            'category_title' => '{news-home-title}',
            'category_subtitle' => '{text_blog_subtitle}',    
        ];

        append_array_to_array($data, $this->viewData);

        $locale = service('request')->getLocale();

        $uri = service('uri');
       
		$segment = $uri->getTotalSegments();
		$perPage = 15;

		$data['galleries'] = $this->galleriesModel->getGalleriesShowHome($locale, true, false, 'ASC', 'show_list', true)->paginate($perPage, 'group', null, $segment);
       
		$data['locale'] = $locale;

		foreach ($data['galleries'] as &$gallery) {
			$gallery->image = $this->galleriesImagesModel->getPrimaryImagesByGalleryId($gallery->id)->image ?? '';
		}
		
        $data['pager'] = $pager;

        return view('template/layout', $data);
	}

	public function viewDetails($slug)
	{
		helper('text');

		$locale = service('request')->getLocale();

		$element = $this->galleriesLanguagesModel->getGallery($slug, $locale);

		if ($element == null) {
			throw new \CodeIgniter\Exceptions\PageNotFoundException($slug);
		}

		$data = [
			'view' => 'App\Modules\Galleries\Views\galleries_filter',
			'images' => $element,
			'galleryTitle' => $element[0]->title,
			'locale' => $locale,
		];

		append_array_to_array($data, $this->viewData);

		if ($element[0]->seo_title != '') {
			$data['seo_title'] = $element[0]->seo_title;
		} else {
			$data['seo_title'] = prepare_string_for_meta($element[0]->title, 60);
		}

		if ($element[0]->meta != '') {
			$data['meta'] = $element[0]->meta;
		} else {
			$data['meta'] = prepare_string_for_meta($element[0]->content, 155);
		}

		//og:image attribute
		if ($element[0]->image != '') {
			$data['image'] = $element[0]->image;
		}

		return view('template/layout', $data);
	}

	public function galleriesHomeBlock($limit = 4)
	{
		helper('text');

		$data = [
			'category_title' => '{text_blog}',
		];

		append_array_to_array($data, $this->viewData);

		$locale = service('request')->getLocale();
		$data['locale'] = $locale;

		$data['galleries'] = $this->galleriesModel->getGalleriesShowHome($locale, true, $limit, 'ASC');

		foreach ($data['galleries'] as &$gallery) {
			$gallery->image = $this->galleriesImagesModel->getPrimaryImagesByGalleryId($gallery->id)->image ?? '';
		}

		return view('App\Modules\Galleries\Views\galleries_list_elements', $data);
	}
}