<?php

namespace App\Modules\Properties\Models;

use CodeIgniter\Model;

class PropertiesLanguagesModel extends Model
{
	protected $db;

	protected $table = 'properties_languages';
	protected $primaryKey = 'id';

	protected $returnType = 'object';
	protected $useSoftDeletes = false;
	protected $allowedFields = ['lang_id', 'property_id', 'title', 'content', 'images_description', 'slug', 'route_id'];
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
	];

	public function savePropertiesLanguages($data)
	{
		$existElement = $this->getPropertyByIdAndLanguageId($data['property_id'], $data['lang_id']);

		if ($existElement !== null) {
			$data['id'] = $existElement->id;
		}

		return $this->save($data, true);
	}

	public function getPropertyByIdAndLanguageId($propertyId, $langId)
	{
		return $this->where(['property_id' => $propertyId, 'lang_id' => $langId])->first();
	}

	public function getPropertyByIdAndLocaleString($id, $locale)
	{
		$builder = $this->builder();

		$builder->select('properties_languages.*, properties.*');
		$builder->join('properties', 'properties_languages.property_id = properties.id');
		$builder->join('languages', 'properties_languages.lang_id = languages.id');
		$builder->where('properties.id', $id);
		$builder->where('languages.active', '1');
		$builder->where('properties.active', '1');
		$builder->where('properties.deleted_at', null);
		$builder->where('languages.code', $locale);

		//$sql = $builder->getCompiledSelect();
		//echo $sql;

		$result = $builder->get()->getRow();

		return $result;
	}

	public function getPropertiesLanguages()
	{
		$builder = $this->builder();

		$builder->select('properties_languages.*');
		$builder->join('properties', 'properties_languages.property_id = properties.id');
		$builder->join('languages', 'properties_languages.lang_id = languages.id');
		$builder->where('languages.active', '1');

		$result = $builder->get()->getResult();

		return $result;
	}

	public function searchPropertiesLanguagesByDefaultSiteLanguage($activeOnly = false, $searchArray)
	{
		$builder = $this->builder();

		$builder->select('properties_languages.*, properties.deleted_at, properties.id, properties.active, properties.category_id');
		$builder->join('properties', 'properties_languages.property_id = properties.id');
		$builder->join('languages', 'properties_languages.lang_id = languages.id');
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

	public function getPropertyLangRowByDefaultSiteLanguage($propertyId)
	{
		$builder = $this->builder();

		$builder->select('properties_languages.*');
		$builder->join('languages', 'properties_languages.lang_id = languages.id');
		$builder->where('property_id', $propertyId);
		$builder->where('languages.side', 'site');
		$builder->where('languages.is_default', '1');
		$builder->where('languages.active', '1');

		return $builder->get()->getFirstRow();
	}

	public function getPropertiesLanguagesByPropertyId($propertyId)
	{
		$builder = $this->builder();

		$builder->select('properties_languages.*');
		$builder->join('languages', 'properties_languages.lang_id = languages.id');
		$builder->where('property_id', $propertyId);
		$builder->where('languages.active', '1');
		$result = $builder->get()->getResult();

		return $result;
	}

	public function getPropertiesLanguagesByLocale($locale, $order = 'DESC', $limit = false)
	{
		$builder = $this->builder();

		$builder->select('properties_languages.*, properties.*, routes.slug as routeSlug');
		$builder->join('properties', 'properties_languages.property_id = properties.id');
		$builder->join('languages', 'properties_languages.lang_id = languages.id');
		$builder->join('routes', 'properties_languages.route_id = routes.id');
		$builder->where('languages.active', '1');
		$builder->where('properties.active', '1');
		$builder->where('properties.deleted_at', null);

		$builder->where('languages.code', $locale);

		//$builder->orderBy('properties.date_end', $order);

		if ($limit) {
			$builder->limit($limit);
		}

		$result = $builder->get()->getResult();

		return $result;
	}

	public function getPCLByCategoryAndLocale($categoryId, $locale, $order = 'DESC', $limit = false)
	{
		$builder = $this->builder();

		$builder->select('properties_languages.*, properties.*');
		$builder->join('properties', 'properties_languages.property_id = properties.id');
		$builder->join('languages', 'properties_languages.lang_id = languages.id');
		$builder->where('properties.category_id', $categoryId);
		$builder->where('languages.active', '1');
		$builder->where('properties.active', '1');
		$builder->where('properties.deleted_at', null);

		$builder->where('languages.code', $locale);

		$builder->orderBy('properties_languages.title', $order);

		if ($limit) {
			$builder->limit($limit);
		}

		return $builder->get()->getResult();
	}



	public function getPropertyBySlugAndLocale($slug, $locale)
	{
		$builder = $this->builder();

		$builder->select('properties_languages.*, properties.*');
		$builder->join('properties', 'properties_languages.property_id = properties.id');
		$builder->join('languages', 'properties_languages.lang_id = languages.id');
		$builder->where('properties_languages.slug', $slug);
		$builder->where('languages.active', '1');
		$builder->where('properties.active', '1');
		$builder->where('properties.deleted_at', null);
		$builder->where('languages.code', $locale);

		//$sql = $builder->getCompiledSelect();
		//echo $sql;

		$result = $builder->get()->getRow();

		return $result;
	}

	public function generatePropertiesDataStructure($locale)
	{
		$builder = $this->db->table('properties_categories_languages as p_c_l');

		$builder->select('p_c_l.slug as category_slug, p_l.slug as property_slug');
		$builder->join('properties as p', 'p.category_id = p_c_l.category_id', 'inner');
		$builder->join('properties_categories as p_c', 'p_c.id = p_c_l.category_id', 'inner');
		$builder->join('properties_languages as p_l', 'p_l.property_id = p.id', 'inner');
		$builder->join('languages', 'p_l.lang_id = languages.id');
		$builder->where('p_c.active', 1);
		$builder->where('p.active', 1);
		$builder->where('p_c.deleted_at', NULL);
		$builder->where('p.deleted_at', NULL);
		$builder->where('languages.active', '1');
		$builder->where('languages.code', $locale);

		$result = $builder->get()->getResult();

		$dataStructure = [];
		foreach ($result as $row) {
			$dataStructure[$row->category_slug][] = $row->property_slug;
		}

		return $dataStructure;
	}


	public function generatePropertiesDataStructureByProductId($productId, $locale)
	{
		$builder = $this->db->table('products_properties as pp');

		$builder->select('p_c_l.slug AS category_slug, p_c_l.title AS category_title, p_c_l.images_description AS category_images_description, 
		p_l.title, p_l.content, p_l.images_description AS images_description, 
		properties_categories_images.image AS category_image, 
		properties_images.image AS image
		');

		$builder->join('properties as p', 'p.id = pp.properties_id', 'inner');
		$builder->join('properties_categories_languages as p_c_l', 'pp.properties_cat_id = p_c_l.category_id');
		$builder->join('properties_categories as p_c', 'p_c.id = p_c_l.category_id', 'inner');
		$builder->join('properties_categories_images', 'p_c.id = properties_categories_images.category_id', 'left');
		$builder->join('properties_languages as p_l', 'p_l.property_id = p.id', 'inner');
		
		$builder->join('properties_images', 'p.id = properties_images.property_id', 'left');
		$builder->join('languages', 'p_l.lang_id = languages.id AND p_c_l.lang_id = languages.id');
    
		// Added condition to filter by product ID.
		
		$builder->where('pp.product_id', $productId);	
		$builder->where('p_c.active', 1);
		$builder->where('p.active', 1);
		$builder->where('p_c.deleted_at', NULL);
		$builder->where('p.deleted_at', NULL);
		$builder->where('languages.active', '1');
		$builder->where('languages.code', $locale);

		$result = $builder->get()->getResult();

		$dataStructure = [];
		foreach ($result as $row) {
			$dataStructure[$row->category_slug] = [
				'category_title' => $row->category_title, 
				'category_image' => $row->category_image, 
				'category_images_description' => $row->category_images_description
			];
		}

		foreach ($result as $row) {
			//$dataStructure[$row->category_slug]['elements'][] = $row;
			$dataStructure[$row->category_slug]['elements'][] = [
				'title' => $row->title, 
				'content' => $row->content, 
				'image' => $row->image, 
				'images_description' => $row->images_description
			];
		}

		return $dataStructure;
	}


	public function generatePropertiesFilters($locale, $productsIdArray = false)
	{
		$builder = $this->db->table('properties_categories_languages as p_c_l');

		$builder->select('p_c_l.slug as category_slug, p_l.slug as property_slug,
    p_c_l.title as category_title, p_l.title as property_title
    ');
		$builder->join('properties as p', 'p.category_id = p_c_l.category_id', 'inner');
		$builder->join('properties_categories as p_c', 'p_c.id = p_c_l.category_id', 'inner');
		$builder->join('properties_languages as p_l', 'p_l.property_id = p.id', 'inner');
		$builder->join('languages', 'p_c_l.lang_id = languages.id AND p_l.lang_id = languages.id ');


		$builder->where('p_c.in_filter', 1);
		$builder->where('p_c.active', 1);
		$builder->where('p.active', 1);
		$builder->where('p_c.deleted_at', NULL);
		$builder->where('p.deleted_at', NULL);
		$builder->where('languages.active', '1');
		$builder->where('languages.code', $locale);

		if ($productsIdArray != false) {
			$builder->join('products_properties as pp', 'pp.properties_id = p.id AND pp.properties_cat_id = p_c.id ');

			$builder->whereIn('pp.product_id', $productsIdArray);
		}

		//$sql = $builder->getCompiledSelect();
		//echo $sql;

		$result = $builder->get()->getResult();

		$dataStructure = [];
		foreach ($result as $row) {
			$dataStructure['categories'][$row->category_slug] = $row->category_title;
			$dataStructure['elements'][$row->category_slug][$row->property_slug] = $row->property_title;
		}

		return $dataStructure;
	}
}
