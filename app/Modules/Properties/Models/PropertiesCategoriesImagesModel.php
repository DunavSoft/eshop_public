<?php namespace App\Modules\Properties\Models;

use CodeIgniter\Model;

class PropertiesCategoriesImagesModel extends Model
{
	protected $db;
	
	protected $table = 'properties_categories_images';
	protected $primaryKey = 'id';

    protected $returnType = 'object';
    protected $useSoftDeletes = false;

    protected $allowedFields = ['id', 'category_id', 'image', 'sequence'];

	// protected $useTimestamps = true;
    //protected $dateFormat = 'int';
    //protected $deletedField  = 'deleted_at';
    protected $skipValidation = true;
	
	public function getArrayImagesByPropertiesCategoryId($propertiesCategoryId)
	{
		/*
		$return = [];
		$_result = $this->where(['propertiesCategory_id' => $propertiesCategoryId])->findAll();
		
		//TODO
		foreach ($_result as $element) {
			$return[$element->category_id] = $element->propertiesCategory_id;
		}
		
		return $return;
		*/
	}
	
	public function getImagesByPropertiesCategoryId($propertiesCategoryId)
	{
		return $this->where(['category_id' => $propertiesCategoryId])->orderBy('sequence', 'ASC')->findAll();
	}
	
	public function getPrimaryImagesByPropertiesCategoryId($propertiesCategoryId)
	{
		return $this->where(['propertiesCategory_id' => $propertiesCategoryId])->orderBy('sequence', 'ASC')->first();
	}
	
	public function savePropertiesCategoryImage($data) 
	{
		if ($data[$this->primaryKey] !== false) {
			if ($this->update($data[$this->primaryKey], $data) !== false) {
				return $data[$this->primaryKey];
			} else {
				return false;
			}
		} else {
			return $this->insert($data, true);
		}
	}
}