<?php

namespace App\Modules\Land\Controllers;

class HomeController extends BaseController
{
	public function index()
	{

		$data = [
			'view' => 'App\Modules\Land\Views\home_index',
			'moduleJS' => [
				//'App\Modules\Land\Views\home_js',
				'App\Modules\Land\Views\products_list_elements_home_js',
				'App\Modules\Land\Views\modalProductAdded_modal.php'
			]
		];

		helper('array_helper');
		helper('form');

		append_array_to_array($data, $this->viewData);

		$locale = service('request')->getLocale();
		$settingsModel = new \App\Modules\Settings\Models\SettingsModel;
		$settings = $settingsModel->getSettingsByLocale($locale);

		foreach ($settings as $element) {
			$data['settings'][$element->setup_key] = $element->setup_value;
		}

		//sliders
		$slidersModel = new \App\Modules\Sliders\Models\SlidersModel;
		$data['slides'] = $slidersModel->getSlidersDataByLocale($locale);

		//get the user agent
		$data['agent'] = $this->request->getUserAgent();

		//articles on homepage
		$articlesController = new \App\Modules\Articles\Controllers\ArticlesController();
		$data['articlesHomeBlock'] = $articlesController->articlesHomeBlock([], 2);

		//galleries on homepage
		$galleriesController = new \App\Modules\Galleries\Controllers\GalleriesController();
		$data['galleriesHomeBlock'] = $galleriesController->galleriesHomeBlock(8);

		helper('dropdown');

		$initializeFilter = function () {
			return [
				'filterColor' => [],
				'filterSize' => [],
				'filterBrands' => [],
				'minPrice' => false,
				'maxPrice' => false,
				'new' => false,
				'promo' => false,
				'top' => false
			];
		};

		//Brands
		$configApp = new \Config\App();
		if (in_array('Brands', $configApp->loadedModules)) {
			$brandsLanguagesModel = new \App\Modules\Brands\Models\BrandsLanguagesModel;

			$filterBrandsArray = $brandsLanguagesModel->getBrandsLanguages($locale) ?? [];

			$data['filterBrandsArray'] = prepare_dropdown($filterBrandsArray, 'brand_id', 'title');
		}

		$getProducts = function ($filterData, $sortData, $productsLanguagesModel, $locale) {
			$products = $productsLanguagesModel
				->getProductsByCategoryLangPaginate('all', $locale, true, [], $sortData, $filterData)
				->paginate(10, 'group', 1, 1);
			$this->_getProductsAdditionalData($products);
			return $products;
		};

		$filterData = $initializeFilter();
		$sortData = [];

		$productsLanguagesModel = new \App\Modules\Products\Models\ProductsLanguagesModel;

		//TOP products on homepage
		$filterData['top'] = true;
		$data['products'] = $getProducts($filterData, $sortData, $productsLanguagesModel, $locale);
		$data['topProducts'] = view('App\Modules\Land\Views\products_list_elements_home', $data);

		//new products
		$filterData = $initializeFilter(); // Reset filters
		$filterData['new'] = true;
		$data['products'] = $getProducts($filterData, $sortData, $productsLanguagesModel, $locale);
		$data['newProducts'] = view('App\Modules\Land\Views\products_list_elements_home', $data);

		//RANDOM FROM ALL PRODUCTS
		$filterData = $initializeFilter(); // Reset filters
		$filterData['top'] = true;
		$sortData = ['sortfilter-products.id' => 'RANDOM'];
		$data['products'] = $getProducts($filterData, $sortData, $productsLanguagesModel, $locale);
		$data['selectionProducts'] = view('App\Modules\Land\Views\products_list_elements_home', $data);

		//brands logos
		$brandsLanguagesModel = new \App\Modules\Brands\Models\BrandsLanguagesModel;
		$data['brands'] = $brandsLanguagesModel->getBrandsLanguagesAndFirstImage($locale);

		//last seen products
		$productsController = new \App\Modules\Products\Controllers\ProductsController;
		$data['last_seen'] = $productsController->lastSeenList();

		$data['seo_url'] = site_url();

		return view('template/layout', $data);
	}
	//--------------------------------------------------------------------

	public function _getProductsAdditionalData(&$products)
	{
		$productsImagesModel = new \App\Modules\Products\Models\ProductsImagesModel;
		$productsCategoriesModel = new \App\Modules\Products\Models\CategoriesLanguagesModel;

		foreach ($products as $product) {
			$product->image = $productsImagesModel->getPrimaryImagesByProductId($product->product_id);

			$decodedDescription = json_decode($product->images_description, true);
			if (is_array($decodedDescription) && count($decodedDescription) > 0) {
				$product->images_description = $decodedDescription[0];
			}

			$category = $productsCategoriesModel->getCategoryById($product->category_id, service('request')->getLocale(), false);
			if ($category) {
				$product->categorySlug = $category->slug;
			}
		}
	}

	public function update_session()
	{
		$session = session();
		$session->set('modal_last_shown', time());

		return json_encode(['status' => 'success']);
	}
}
