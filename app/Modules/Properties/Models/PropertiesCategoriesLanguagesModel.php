<?php namespace App\Modules\Properties\Models;

use CodeIgniter\Model;

class PropertiesCategoriesLanguagesModel extends Model
{
	protected $db;
	
	protected $table = 'properties_categories_languages';
	protected $primaryKey = 'id';

    protected $returnType = 'object';
    protected $useSoftDeletes = false;
    protected $allowedFields = ['lang_id', 'category_id', 'title', 'content', 'multiple_choice', 'in_filter', 'images_description', 'slug', 'route_id'];
    protected $useTimestamps = false;
    protected $skipValidation = false;

	protected $validationRules = [
		'title' => [
            'label' => 'AdminPanel.title',
            'rules' => 'trim|required|max_length[256]',
        ],
		'slug' => [
            'label' => 'AdminPanel.slug',
            'rules' => 'trim|required|max_length[256]',
        ],
		'content' => [
            'label' => 'AdminPanel.content',
            'rules' => 'trim',
        ],
		'multiple_choice' => [
            'label' => 'PropertiesLang.multiple_choice',
            'rules' => 'trim',
        ],
		'in_filter' => [
            'label' => 'PropertiesLang.in_filter',
            'rules' => 'trim',
        ],
		'images_description' => [
            'label' => '',
            'rules' => 'trim',
        ],
    ];
	
	public function savePropertiesCategoriesLanguages($data)
	{
		$existElement = $this->getPropertyByIdAndLanguageId($data['category_id'], $data['lang_id']);
		
		if ($existElement !== null) {
			$data['id'] = $existElement->id;
		}
		
		return $this->save($data, true);
	}
	
	public function getPropertyByIdAndLanguageId($categoryId, $langId)
	{
		return $this->where(['category_id' => $categoryId, 'lang_id' => $langId])->first();
	}
	
	public function getPropertyByIdAndLocaleString($id, $locale)
	{
		$builder = $this->builder();
		
		$builder->select('properties_categories_languages.*, properties_categories.*');
		$builder->join('properties_categories', 'properties_categories_languages.category_id = properties_categories.id');
		$builder->join('languages', 'properties_categories_languages.lang_id = languages.id');
		$builder->where('properties_categories.id', $id);
		$builder->where('languages.active', '1');
		$builder->where('properties_categories.active', '1');
		$builder->where('properties_categories.deleted_at', null);
		$builder->where('languages.code', $locale);
		
		//$sql = $builder->getCompiledSelect();
		//echo $sql;
		
		$result = $builder->get()->getRow();
		
		return $result;
	}
	
	public function getPropertiesLanguages()
	{
		$builder = $this->builder();
		
		$builder->select('properties_categories_languages.*');
		$builder->join('properties_categories', 'properties_categories_languages.category_id = properties_categories.id');
		$builder->join('languages', 'properties_categories_languages.lang_id = languages.id');
		$builder->where('languages.active', '1');
		
		$result = $builder->get()->getResult();

		return $result;
	}
	
	public function searchPropertiesCategoriesLanguagesByDefaultSiteLanguage($activeOnly = false, $searchArray)
	{
		$builder = $this->builder();
		
		$builder->select('properties_categories_languages.*, properties_categories.deleted_at, properties_categories.id, properties_categories.active');
		$builder->join('properties_categories', 'properties_categories_languages.category_id = properties_categories.id');
		$builder->join('languages', 'properties_categories_languages.lang_id = languages.id');
		$builder->where('languages.active', '1');
		$builder->where('languages.side', 'site');
		$builder->where('languages.is_default', '1');
		
		$builder->groupStart();
		foreach ($searchArray as $key => $value) {
			$builder->orLike($key, $value);
		}
		$builder->groupEnd();
		
		//echo $builder->getCompiledSelect(false);
		return $this;
	}
	
	public function getPropertyLangRowByDefaultSiteLanguage($categoryId)
	{
		$builder = $this->builder();
		
		$builder->select('properties_categories_languages.*');
		$builder->join('languages', 'properties_categories_languages.lang_id = languages.id');
		$builder->where('category_id', $categoryId);
		$builder->where('languages.side', 'site');
		$builder->where('languages.is_default', '1');
		$builder->where('languages.active', '1');
		
		return $builder->get()->getFirstRow();
	}
	
	public function getPropertiesCategoriesLanguagesByPropertyId($categoryId)
	{
		$builder = $this->builder();
		
		$builder->select('properties_categories_languages.*');
		$builder->join('languages', 'properties_categories_languages.lang_id = languages.id');
		$builder->where('category_id', $categoryId);
		$builder->where('languages.active', '1');
		$result = $builder->get()->getResult();

		return $result;
	}
	
	public function getPropertiesCategoriesLanguagesByLocale($locale, $order = 'ASC', $active = true, $limit = false)
	{
		$builder = $this->builder();
		
		$builder->select('properties_categories_languages.*, properties_categories.*');
		$builder->join('properties_categories', 'properties_categories_languages.category_id = properties_categories.id');
		$builder->join('languages', 'properties_categories_languages.lang_id = languages.id');
		$builder->where('languages.active', '1');
		
		$builder->where('properties_categories.deleted_at', null);
		$builder->where('languages.code', $locale);
		
		//$builder->orderBy('properties_categories.sequence', $order);
		
		if ($limit) {
			$builder->limit($limit);
		}
		
		if ($active) {
			$builder->where('properties_categories.active', '1');
		}
		
		
		
		$result = $builder->get()->getResult();

		return $result;
	}
	
	public function getPropertyBySlugAndLocale($slug, $locale)
	{
		$builder = $this->builder();
		
		$builder->select('properties_categories_languages.*, properties_categories.*');
		$builder->join('properties_categories', 'properties_categories_languages.category_id = properties_categories.id');
		$builder->join('languages', 'properties_categories_languages.lang_id = languages.id');
		$builder->where('properties_categories_languages.slug', $slug);
		$builder->where('languages.active', '1');
		$builder->where('properties_categories.active', '1');
		$builder->where('properties_categories.deleted_at', null);
		$builder->where('languages.code', $locale);
		
		//$sql = $builder->getCompiledSelect();
		//echo $sql;
		
		$result = $builder->get()->getRow();
		
		return $result;
	}
}