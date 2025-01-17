<?php namespace App\Modules\Admin\Models;

use CodeIgniter\Model;

class AdminModel extends Model
{
	protected $db;
	
	protected $table = 'admin';
	protected $primaryKey = 'id';

    protected $returnType = 'object';
    protected $useSoftDeletes = true;

    protected $allowedFields = ['firstname', 'lastname', 'email', 'access', 'password', 'language'];

    protected $useTimestamps = true;
    protected $dateFormat = 'int';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    protected $skipValidation = false;
	
	protected $validationRules = [];

	// we need different rules for register, edit
	protected $dynamicRules = [
		'createAdministrator' => [
			'firstname' 		=> 'trim|required|min_length[2]|max_length[64]',
			'lastname' 			=> 'trim|max_length[64]',
			'email' 			=> 'trim|required|max_length[128]|is_unique[admin.email]',
			'password'			=> 'required|min_length[6]',
			'confirm'			=> 'matches[password]'
		],
		'editAdministrator' => [
			'firstname' 		=> 'trim|required|min_length[2]|max_length[64]',
			'lastname' 			=> 'trim|max_length[64]',
		],
		'editAdministratorWithPassword' => [
			'firstname' 		=> 'trim|required|min_length[2]|max_length[64]',
			'lastname' 			=> 'trim|max_length[64]',
			'password'			=> 'required|min_length[6]',
			'confirm'			=> 'matches[password]'
		]
	];

	protected $validationMessages = [];
	
	protected $allowCallbacks = true;
	
	// this runs after field validation
	protected $beforeInsert = ['hashPassword'];
	protected $beforeUpdate = ['hashPassword'];
	
	//--------------------------------------------------------------------
	
	/**
	* Retrieves all Administrators data
	*/
	public function getAdministrators($deleted = false)
	{
		$this->orderBy('id', 'ASC');
		
		if ($deleted == 'deleted') {
			$result = $this->onlyDeleted()->findAll();
		} else {
			$result = $this->findAll();
		}

		return $result;
	}
	
	//--------------------------------------------------------------------

	/**
	* Retrieves Administrator data
	*/
	public function getAdministrator($id)
	{
		return $this->where(['id' => $id])->first();
	}
	
	//--------------------------------------------------------------------

	/**
	*
	*/
	public function saveAdministrator($data) {
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
	
	//--------------------------------------------------------------------

	/**
	* Retrieves database columns data to set defaults in the forms
	*/
	public function getFieldData()
    {
        return $this->db->getFieldData($this->table);
    }
	
	//--------------------------------------------------------------------

    /**
     * Retrieves validation rule
     */
	public function getRule(string $rule)
	{
		return $this->dynamicRules[$rule];
	}
	
	 /**
     * Hashes the password after field validation and before insert/update
     */
	protected function hashPassword(array $data)
	{
		if (! isset($data['data']['password'])) return $data;
		
		if ($data['data']['password'] == '') {
			unset($data['data']['password']);
			return $data;
		}

		$data['data']['password'] = password_hash($data['data']['password'], PASSWORD_DEFAULT);
		unset($data['data']['confirm']);

		return $data;
	}
	
	//--------------------------------------------------------------------

	/**
	* Retrieves Administrator data
	*/
	public function getOtherAdministrator($id, $myId)
	{
		return $this->where(['id' => $id, 'id !=' => $myId])->first();
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
	
}