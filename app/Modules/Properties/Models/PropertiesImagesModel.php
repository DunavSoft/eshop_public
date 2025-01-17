<?php namespace App\Modules\Properties\Models;

use CodeIgniter\Model;

class PropertiesImagesModel extends Model
{
	protected $db;
	
	protected $table = 'properties_images';
	protected $primaryKey = 'id';

    protected $returnType = 'object';
    protected $useSoftDeletes = false;

    protected $allowedFields = ['property_id', 'image', 'sequence'];

	// protected $useTimestamps = true;
    //protected $dateFormat = 'int';
    //protected $deletedField  = 'deleted_at';
    protected $skipValidation = true;
	
	public function getArrayImagesByPropertyId($propertyId)
	{
		/*
		$return = [];
		$_result = $this->where(['property_id' => $propertyId])->findAll();
		
		//TODO
		foreach ($_result as $element) {
			$return[$element->category_id] = $element->property_id;
		}
		
		return $return;
		*/
	}
	
	public function getImagesByPropertyId($propertyId)
	{
		return $this->where(['property_id' => $propertyId])->orderBy('sequence', 'ASC')->findAll();
	}
	
	public function getPrimaryImagesByPropertyId($propertyId)
	{
		return $this->where(['property_id' => $propertyId])->orderBy('sequence', 'ASC')->first();
	}
	
	public function savePropertyImage($data) 
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