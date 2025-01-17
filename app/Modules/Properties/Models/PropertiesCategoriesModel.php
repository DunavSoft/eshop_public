<?php namespace App\Modules\Properties\Models;

use CodeIgniter\Model;

class PropertiesCategoriesModel extends Model
{
	protected $db;
	
	protected $table = 'properties_categories';
	protected $primaryKey = 'id';

    protected $returnType = 'object';
    protected $useSoftDeletes = true;

    protected $allowedFields = ['active', 'sequence', 'multiple_choice', 'in_filter'];

    protected $useTimestamps = true;
    protected $dateFormat = 'int';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    protected $skipValidation = false;
	
	protected $validationRules = [
		'active' => [
            'label' => '',
            'rules' => 'trim|numeric',
        ],
		'sequence' => [
            'label' => '',
            'rules' => 'trim|numeric',
        ],
		'multiple_choice' => [
            'label' => '',
            'rules' => 'trim|numeric',
        ],
		'in_filter' => [
            'label' => '',
            'rules' => 'trim|numeric',
        ],
	/*
		'date_start' => [
            'label' => 'PropertiesLang.dateStart',
            'rules' => 'trim|numeric',
        ],
		'date_end' => [
            'label' => 'PropertiesLang.dateEnd',
            'rules' => 'trim|required|numeric',
        ],
	*/
    ];
	
	public function getFieldData()
    {
        return $this->db->getFieldData($this->table);
    }
	
	//using pagination
	public function getElements($deleted, $activeOnly = false)
	{
		$builder = $this->builder();
		
		$builder->orderBy('sequence', 'ASC');
		
		if ($activeOnly) {
			$builder->where('active', '1');
		}
		
		$builder->where('deleted_at', null);
		
		//echo $builder->getCompiledSelect(false);exit;

        return $this; // This will allow the call chain to be used.
	}
	
	public function getDeletedElements()
	{
		$this->orderBy('id', 'DESC');

		return $this->onlyDeleted()->findAll();
	}
	
	public function getElementBySlug($slug)
	{
		return $this->where(['slug' => $slug])->first();
	}	
	
	public function getElementById($id)
	{
		return $this->where(['id' => $id])->first();
	}	
	
	public function saveElement($data) 
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
	
	public function restore($id) 
	{
		$this->allowedFields = ['deleted_at'];
		$this->set('deleted_at', null);
		
		if ($this->update($id) !== false) {
			return true;
		} else {
			return false;
		}
	}
}