<?php namespace App\Modules\Settings\Models;

use CodeIgniter\Model;

class SettingsLanguagesModel extends Model
{
	protected $db;
	
	protected $table = 'settings_languages';
	protected $primaryKey = 'id';

    protected $returnType = 'object';
    protected $useSoftDeletes = true;

    protected $allowedFields = ['title', 'lang_id', 'category_id', 'seo_title', 'meta', 'slug', 'excerpt', 'content', 'img_alt', 'img_title'];

    protected $useTimestamps = false;
    protected $dateFormat = 'int';
   
    protected $skipValidation = false;

	protected $validationRules = [
        'title' => 'trim|min_length[1]|max_length[256]',
        'excerpt' => 'trim',
        'content' => 'trim',
        'seo_title' => 'trim',
        'meta' => 'trim',
        'slug' => 'trim|max_length[256]',
        'img_alt' => 'trim|max_length[256]',
        'img_title' => 'trim|max_length[256]',
    ];
	
	/*
	protected $validationMessages = [
        'title'        => [
            'required' => 'The {field} field is required.'
        ]
    ];
	
	public function __construct(ConnectionInterface &$db = null, ValidationInterface $validation = null) {
        parent::__construct($db, $validation);
    }
	*/
	
	public function saveSettingsLanguages($data)
	{
		$existElement = $this->_getSettingsLanguages($data['lang_id'], $data['category_id']);
		
		if ($existElement !== null) {
			$data['id'] = $existElement->id;
		} 
		
		return $this->save($data);
	}
	
	
	private function _getSettingsLanguages($langID, $categoryID)
	{
		return $this->where(['lang_id' => $langID, 'category_id' => $categoryID])->first();
	}
	
	public function getCategoryLanguage($langID, $categoryID)
	{
		return $this->where(['lang_id' => $langID, 'category_id' => $categoryID])->first();
	}
	
	public function getCategory($slug, $language)
	{
		$builder = $this->builder();
		
		$builder->select('settings_languages.*');
		$builder->join('settings', 'settings_languages.category_id = settings.id');
		$builder->join('languages', 'settings_languages.lang_id = languages.id');
		$builder->where('slug', $slug);
		$builder->where('languages.active', '1');
		$builder->where('languages.code', $language);
		$builder->where('settings.active', '1');
		$result = $builder->get()->getRow();
		
		return $result;
	}
	
	
	public function getSettingsLanguages()
	{
		$builder = $this->builder();
		
		$builder->select('settings_languages.*');
		$builder->join('settings', 'settings_languages.category_id = settings.id');
		$builder->join('languages', 'settings_languages.lang_id = languages.id');
		//$builder->where('category_id', $categoryID);
		$builder->where('languages.active', '1');
		$result = $builder->get()->getResult();

		return $result;
	}
	
}