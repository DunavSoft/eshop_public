<?php namespace App\Modules\Pages\Models;

use CodeIgniter\Model;

class PagesLanguagesModel extends Model
{
	protected $db;
	
	protected $table = 'pages_languages';
	protected $primaryKey = 'id';

    protected $returnType = 'object';
    protected $useSoftDeletes = true;

    protected $allowedFields = ['title', 'lang_id', 'page_id', 'route_id', 'seo_title', 'meta', 'slug', 'content', 'img_alt', 'img_title', 'resp_img_alt', 'resp_img_title'];

    protected $useTimestamps = false;
    protected $dateFormat = 'int';
   
    protected $skipValidation = false;

	protected $validationRules = [
        'title' => [
			'label' => 'AdminPagesLang.Title',
			'rules' => 'trim|required|min_length[1]|max_length[256]',
		],
        'content' => [
			'rules' => 'trim',
		],
		'slug' => [
			'label' => 'AdminPanel.slug',
			'rules' => 'trim|max_length[256]',
		],
        'seo_title' => [
			'label' => 'AdminPanel.seoTitle',
			'rules' => 'trim',
		],
        'meta' => [
			'label' => 'AdminPanel.seoMeta',
			'rules' => 'trim',
		],
        'img_alt' => [
			'label' => 'AdminPanel.imgAlt',
			'rules' => 'trim|max_length[256]',
		],
        'img_title' => [
			'label' => 'AdminPanel.imgTitle',
			'rules' => 'trim|max_length[256]',
		],
		'resp_img_alt' => [
			'label' => 'AdminPanel.respImgAlt',
			'rules' => 'trim|max_length[256]',
		],
        'resp_img_title' => [
			'label' => 'AdminPanel.respImgTitle',
			'rules' => 'trim|max_length[256]',
		],
    ];
	
	public function savePagesLanguages($data) 
	{
		$existElement = $this->_getPageLanguage($data['lang_id'], $data['page_id']);
		
		if ($existElement !== null) {
			$data['id'] = $existElement->id;
		} 
		
		return $this->save($data);
	}
	
	private function _getPageLanguage($langID, $pageID)
	{
		return $this->where(['lang_id' => $langID, 'page_id' => $pageID])->first();
	}
	
	public function getPageLanguage($langID, $pageID)
	{
		return $this->where(['lang_id' => $langID, 'page_id' => $pageID])->first();
	}
	
	public function getPage($slug, $language)
	{
		$builder = $this->builder();
		
		$builder->select('pages_languages.*, pages.*, routes.slug as route_slug');
		$builder->join('pages', 'pages_languages.page_id = pages.id');
		$builder->join('languages', 'pages_languages.lang_id = languages.id');
		$builder->join('routes', 'pages_languages.route_id = routes.id');
		$builder->where('routes.slug', $slug);
		$builder->where('languages.active', '1');
		$builder->where('languages.code', $language);
		$builder->where('pages.active', '1');
		$builder->where('pages.deleted_at', null);
		$result = $builder->get()->getRow();
		
		return $result;
	}
	
	public function getPagesLanguages()
	{
		$builder = $this->builder();
		
		$builder->select('pages_languages.*');
		$builder->join('pages', 'pages_languages.page_id = pages.id');
		$builder->join('languages', 'pages_languages.lang_id = languages.id');
		$builder->where('languages.active', '1');
		$result = $builder->get()->getResult();

		return $result;
	}
	
	public function getPagesLangSlugs($locale) : array
	{
		$builder = $this->builder();
		
		$builder->select('pages_languages.page_id, routes.slug as route_slug');
		$builder->join('pages', 'pages_languages.page_id = pages.id');
		$builder->join('languages', 'pages_languages.lang_id = languages.id');
		$builder->join('routes', 'pages_languages.route_id = routes.id');
		$builder->where('languages.active', '1');
		$builder->where('languages.code', $locale);
		$builder->where('pages.active', '1');
		$builder->where('pages.deleted_at', null);
		$result = $builder->get()->getResult();
		
		$returnArray = [];
		foreach ($result as $element) {
			$returnArray[$element->page_id] = $element->route_slug;
		}
		
		return $returnArray;
	}

	public function getPagesLangTitles($locale) : array
	{
		$builder = $this->builder();
		
		$builder->select('pages_languages.page_id, pages_languages.title');
		$builder->join('pages', 'pages_languages.page_id = pages.id');
		$builder->join('languages', 'pages_languages.lang_id = languages.id');
		$builder->join('routes', 'pages_languages.route_id = routes.id');
		$builder->where('languages.active', '1');
		$builder->where('languages.code', $locale);
		$builder->where('pages.active', '1');
		$builder->where('pages.deleted_at', null);
		$result = $builder->get()->getResult();
		
		$returnArray = [];
		foreach ($result as $element) {
			$returnArray[$element->page_id] = $element->title;
		}
		
		return $returnArray;
	}
}