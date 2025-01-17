<?php namespace App\Modules\Languages\Models;

use CodeIgniter\Model;

class LanguagesModel extends Model
{
	protected $db;
	
	protected $table = 'languages';
	protected $primaryKey = 'id';

    protected $returnType = 'object';
    protected $useSoftDeletes = false;

    protected $allowedFields = ['active', 'is_default', 'hidden'];
/*
    protected $useTimestamps = true;
    protected $dateFormat = 'int';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';
*/
    protected $skipValidation = false;

	protected $validationRules = [
        'active' => 'trim',
        'site_is_default' => 'trim|required',
        'admin_is_default' => 'trim|required',
        'hidden' => 'trim',
    ];
	
	public function getFieldData()
    {
        return $this->db->getFieldData($this->table);
    }
	
	public function getElements($side = 'admin')
	{
		$this->orderBy('is_default', 'DESC');
		$this->orderBy('active', 'DESC');
		$this->orderBy('sequence', 'ASC');
		$this->where('side', $side);
		
		$result = $this->findAll();
		
		return $result;
	}
	
	public function getActiveElements($side = 'admin', $show_hidden = true, $excluded_locale = false)
	{
		$this->orderBy('is_default', 'DESC');
		$this->orderBy('sequence', 'ASC');
		$this->where('side', $side);
		$this->where('active', '1');
		if (!$show_hidden) {
			$this->where('hidden', '0');
		}
		if ($excluded_locale != false) {
			$this->where('code != ', $excluded_locale);
		}
		
		$result = $this->findAll();
		
		return $result;
	}
	
	
	public function getElement($side, $uri)
	{
		return $this->where(['side' => $side, 'uri' => $uri])->first();
	}
	
	public function getDefaultSiteLanguage()
	{
		return $this->where(['side' => 'site', 'is_default' => '1'])->first();
	}
	
	public function getDefaultAdminLanguage()
	{
		return $this->where(['side' => 'admin', 'is_default' => '1'])->first();
	}
	
	public function saveElement($data) {
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
	
	
	public function saveLanguage($active_array, $is_default, $hidden_array = false) {
		$flag = true;
		
		if ($active_array != false) {
			foreach ($active_array as $key => $val) {
				if ($this->update($val, ['active' => '1']) == false) {
					$flag = false;
				}
			}
		}
		
		if ($hidden_array != false) {
			foreach ($hidden_array as $key => $val) {
				if ($this->update($val, ['hidden' => '1']) == false) {
					$flag = false;
				}
			}
		}
		
		if ($is_default != false) {
			if ($this->update($is_default, ['is_default' => '1', 'active' => '1']) == false) {
				$flag = false;
			}
		} else {
			$flag = false;
		}
		return $flag;
	}
	
	public function clearLanguageSettings() {
		$data = ['active' => '0', 'is_default' => '0', 'hidden' => '0'];
		if ($this->update(null, $data) !== false) {
			return true;
		} else {
			return false;
		}
	}
}