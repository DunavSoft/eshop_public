<?php namespace App\Modules\Admin\Controllers;

use App\Modules\Admin\Models\UserModel;
use App\Modules\Articles\Models\ArticlesModel;
use App\Modules\Galleries\Models\GalleriesModel;
use App\Modules\Languages\Models\LanguagesModel;
use App\Modules\Orders\Models\OrdersModel;
use App\Modules\Pages\Models\PagesModel;
use App\Modules\Payments\Models\PaymentsTransactionsModel;
use App\Modules\Products\Models\CategoriesModel;
use App\Modules\Products\Models\ProductsModel;
use App\Modules\Sliders\Models\SlidersModel;
use CodeIgniter\Controller;

class Dashboard extends BaseController
{
    public $viewData;
    protected $userModel;
	protected $languagesModel;
    protected $config;

    protected $pagesModel;
    protected $productsCategoriesModel;
    protected $productsModel;
    protected $articlesModel;
    protected $galleriesModel;
    protected $slidersModel;
    protected $ordersModel;
    protected $paymentsTransactionsModel;


    /**
     * Constructor.
     */
    public function __construct()
    {
        $this->config = new \Config\App();

        $this->userModel = new UserModel();

        $this->languagesModel = new LanguagesModel();
        $this->pagesModel = new PagesModel();
        $this->productsCategoriesModel = new CategoriesModel();
        $this->productsModel = new ProductsModel();
        $this->articlesModel = new ArticlesModel();
        $this->galleriesModel = new GalleriesModel();
        $this->slidersModel = new SlidersModel();
        $this->ordersModel = new OrdersModel();
        $this->paymentsTransactionsModel = new PaymentsTransactionsModel();
    }

    public function index()
	{
        $this->viewData['activeMenu'] = 'dashboard';
        $data = $this->viewData;

        $data['config'] = $this->config;
        $data['pageTitle'] = 'Dashboard';
        $data['title'] = 'Dashboard Page';
        $data['view'] = 'App\Modules\Admin\Views\dashboard';
        $data['ajax_view'] = 'App\Modules\Admin\Views\dashboard_index_ajax';
        $data['javascript'] = [
            'App\Modules\Admin\Views\dashboard_js',
            'App\Views\template\modals',
        ];

        $data['pages'] = $this->pagesModel->where('active', 1)->countAllResults();
        $data['categories'] = $this->productsCategoriesModel->where('active', 1)->countAllResults();
        $data['products'] = $this->productsModel->where('active', 1)->countAllResults();
        $data['articles'] = $this->articlesModel->where('active', 1)->countAllResults();
        $data['galleries'] = $this->galleriesModel->where('active', 1)->countAllResults();
        $data['sliders'] = $this->slidersModel->where('active', 1)->countAllResults();

        if (in_array('Orders', $this->config->loadedModules)) {
            $data['orders'] = $this->ordersModel->orderBy('ordered_on', 'DESC')->findAll(15);
        }

        $transactions = $this->paymentsTransactionsModel
			->where('payment_status', 'COMPLETED')
			->orWhere('payment_status', 'Approved. No errors')
			->findAll();

		foreach($transactions as $transaction){
			$data['paid'][$transaction->order_id] = $transaction;
		}	

        if ($this->request->isAJAX()) {
            $data['is_ajax'] = true;
            return view('App\Modules\Admin\Views\dashboard_index_ajax', $data);
        }

        return view('template/admin', $data);
    }

}
