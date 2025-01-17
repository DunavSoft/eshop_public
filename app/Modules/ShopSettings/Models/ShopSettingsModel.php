<?php namespace App\Modules\ShopSettings\Models;

use CodeIgniter\Model;

class ShopSettingsModel extends Model
{
	protected $db;
	
	protected $table = 'shopsettings';
	protected $primaryKey = 'id';

    protected $returnType = 'object';
    protected $useSoftDeletes = true;

    protected $allowedFields = ['setup_key', 'setup_value', 'locale'];

    protected $useTimestamps = true;
    protected $dateFormat = 'int';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    protected $skipValidation = false;
/*
	protected $validationRules = [
        'image' => 'trim',
        'image_responsive' => 'trim',
        'sequence' => 'trim|numeric',
        'active' => 'trim|numeric'
    ];
*/	
	
	public function getFieldData()
    {
        return $this->db->getFieldData($this->table);
    }
	
	public function getShopSettings($deleted = 0)
	{
		if ($deleted == 0) {
			$result = $this->findAll();
		} else {
			$result = $this->onlyDeleted()->findAll();
		}

		return $result;
	}

	public function getElement($setup_key, $locale)
	{
		return $this->where(['setup_key' => $setup_key, 'locale' => $locale])->first();
	}
	
	
	public function saveShopSettings($data) {
		$existingElement = $this->getElement($data['setup_key'], $data['locale']);
		
		if ($existingElement != null) {
			
			$this->update($existingElement->{$this->primaryKey}, $data);
			
			return $existingElement->{$this->primaryKey};
		} else {
			return $this->insert($data, true);
		}
	}
	
	public function restore($id) {
		$this->allowedFields = ['deleted_at'];
		$this->set('deleted_at', null);
		
		if ($this->update($id) !== false) {
			return true;
		} else {
			return false;
		}
	}
	
	
	public function getShopSettingsByLocale($locale)
	{
		return $this->where(['locale' => $locale])->findAll();
	}
}