<?php namespace App\Modules\Colors\Models;

use CodeIgniter\Model;

class ColorsLanguagesModel extends Model
{
	protected $db;
	
	protected $table = 'colors_languages';
	protected $primaryKey = 'id';

    protected $returnType = 'object';
    protected $useSoftDeletes = false;
    protected $allowedFields = ['lang_id', 'color_id', 'title', 'images_description'];
    protected $useTimestamps = false;
    protected $skipValidation = false;

	protected $validationRules = [
		'title' => [
            'label' => 'AdminPanel.title',
            'rules' => 'trim|required|max_length[256]',
        ],
    ];
	
	protected $validationLabels = [
        'title' => 'lang.title',
        //'img_alt' => 'wef',
        //'img_title' => 'htr',
    ];
	
	public function saveColorsLanguages($data)
	{
		$existElement = $this->getColorByIdAndLanguageId($data['color_id'], $data['lang_id']);
		
		if ($existElement !== null) {
			$data['id'] = $existElement->id;
		}
		
		return $this->save($data, true);
	}
	
	public function getColorByIdAndLanguageId($colorId, $langId)
	{
		return $this->where(['color_id' => $colorId, 'lang_id' => $langId])->first();
	}

	public function getColorByIdAndLocale($colorId, $locale)
	{
		$builder = $this->builder();
		
		$builder->select('colors_languages.*, colors.image');
		$builder->join('colors', 'colors_languages.color_id = colors.id');
		$builder->join('languages', 'colors_languages.lang_id = languages.id');
		$builder->where('languages.active', '1');
		$builder->where('languages.code', $locale);
		$builder->where('colors_languages.color_id', $colorId);
		
		return $builder->get()->getRow();
	}
	
	public function getColorByIdAndLocaleString($id, $locale)
	{
		$builder = $this->builder();
		
		$builder->select('colors_languages.*, colors.*');
		$builder->join('colors', 'colors_languages.color_id = colors.id');
		$builder->join('languages', 'colors_languages.lang_id = languages.id');
		$builder->where('colors.id', $id);
		$builder->where('languages.active', '1');
		$builder->where('colors.active', '1');
		$builder->where('colors.deleted_at', null);
		$builder->where('languages.code', $locale);
		
		//$sql = $builder->getCompiledSelect();
		//echo $sql;
		
		$result = $builder->get()->getRow();
		
		return $result;
	}
	
	public function getColorsLanguages()
	{
		$builder = $this->builder();
		
		$builder->select('colors_languages.*');
		$builder->join('colors', 'colors_languages.color_id = colors.id');
		$builder->join('languages', 'colors_languages.lang_id = languages.id');
		$builder->where('languages.active', '1');
		
		$result = $builder->get()->getResult();

		return $result;
	}
  
  public function getColorsLanguagesByLocale($locale)
	{
		$builder = $this->builder();
		
		$builder->select('colors_languages.*');
		$builder->join('colors', 'colors_languages.color_id = colors.id');
		$builder->join('languages', 'colors_languages.lang_id = languages.id');
		$builder->where('languages.active', '1');
    $builder->where('languages.code', $locale);
    $builder->where('colors.deleted_at', null);
		
		return $builder->get()->getResult();
	}
	
	public function searchColorsLanguagesByDefaultSiteLanguage($activeOnly = false, $searchArray)
	{
		$builder = $this->builder();
		
		$builder->select('colors_languages.*, colors.deleted_at, colors.id');
		$builder->join('colors', 'colors_languages.color_id = colors.id');
		$builder->join('languages', 'colors_languages.lang_id = languages.id');
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
	
	public function getColorLangRowByDefaultSiteLanguage($colorId)
	{
		$builder = $this->builder();
		
		$builder->select('colors_languages.*');
		$builder->join('languages', 'colors_languages.lang_id = languages.id');
		$builder->where('color_id', $colorId);
		$builder->where('languages.side', 'site');
		$builder->where('languages.is_default', '1');
		$builder->where('languages.active', '1');
		
		return $builder->get()->getFirstRow();
	}
	
	public function getColorsLanguagesByColorId($colorId)
	{
		$builder = $this->builder();
		
		$builder->select('colors_languages.*');
		$builder->join('languages', 'colors_languages.lang_id = languages.id');
		$builder->where('color_id', $colorId);
		$builder->where('languages.active', '1');
		$result = $builder->get()->getResult();

		return $result;
	}
  
  
  public function getColorsByLocaleAndIdArray($locale, $colorsIdArray)
	{
		$builder = $this->builder();

		$builder->select('*');
		
		$builder->join('languages', 'colors_languages.lang_id = languages.id');
    $builder->join('colors', 'colors_languages.color_id = colors.id');
		
    $builder->where('languages.code', $locale);
    
    if (is_array($colorsIdArray)) {
      $builder->whereIn('color_id', $colorsIdArray);
    }
    
		return $builder->get()->getResult();
	}
  
}