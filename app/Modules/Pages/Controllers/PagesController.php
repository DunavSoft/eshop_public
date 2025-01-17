<?php
/**
 * @package Pages
 * @subpackage xxx
 * @version 1.0.0.0
 * @author Georgi Nechovski
 */

namespace App\Modules\Pages\Controllers;

use App\Libraries\Breadcrumb;

class PagesController extends BaseController
{
    protected $pagesModel;
    protected $pagesLanguagesModel;
    protected $languagesModel;
    protected $breadcrumb;

    /**
     * Constructor.
     */
    public function __construct()
    {
        $this->pagesModel = new \App\Modules\Pages\Models\PagesModel();
        $this->pagesLanguagesModel = new \App\Modules\Pages\Models\PagesLanguagesModel();
		$this->languagesModel = new \App\Modules\Languages\Models\LanguagesModel();
        $this->breadcrumb = new Breadcrumb();
    }

    /**
     * Gets homepage
     *
     * @return view('template/layout')
     */
    public function index()
    {
        $data = [
            'title' => 'Pages Page',
            'view' => 'admin/dashboard'
        ];

        return view('template/layout', $data);
    }

    /**
     * Gets page, based on URI. Take notice that we pass URI parameter directly from service('uri').
     * In this case we dont need to define /page/ in the URL
     *
     * @return view('template/layout')
     */
    public function view()
    {
		helper('text');
		helper('array_helper');
        $uri = service('uri');

        $total = $uri->getTotalSegments();
        $segments = $uri->getSegments();

        if (is_array($segments) && $total > 1) {
            $slug = $segments[$total - 1];
        } elseif (is_array($segments) && $total == 1) {
            $slug = $segments[0];
        } else {
            $slug = $segments;
        }

        $locale = service('request')->getLocale();

        $element = $this->pagesLanguagesModel->getPage($slug, $locale);

        if ($element == null) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException($slug);
        }

        $breadcrumb = array_merge($this->breadcrumb->getBreadcrumb('main_menu_left'), $this->breadcrumb->getBreadcrumb('main_menu_right'));

        $data = [
            'view' => 'App\Modules\Pages\Views\pages_view',
            'page' => $element,
            'locale' => $locale,
            'breadcrumb' => $breadcrumb,
        ];
		
		append_array_to_array($data, $this->viewData);

        if ($element->seo_title != '') {
            $data['seo_title'] = $element->seo_title;
        } else {
            //$data['seo_title'] = mb_substr(strip_tags($element->title),0,60);
            $data['seo_title'] = prepare_string_for_meta($element->title, 60);
        }

        if ($element->meta != '') {
            $data['meta'] = $element->meta;
        } else {
			$data['meta'] = prepare_string_for_meta($element->content, 155);
		}

        //og:image attribute
        if ($element->image != '') {
            $data['image'] = $element->image;
        }
		
        //og:type attribute = article for articles only
        //$data['article'] = 'article';

        $settingsModel = new \App\Modules\Settings\Models\SettingsModel;
        $locale = service('request')->getLocale();

        $settings = $settingsModel->getSettingsByLocale($locale);
        foreach ($settings as $element) {
            $data['settings'][$element->setup_key] = $element->setup_value;
        }

        return view('template/layout', $data);
    }
}