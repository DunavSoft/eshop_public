<?php namespace App\Modules\Users\Models;

use CodeIgniter\Model;

class UsersModel extends Model
{
	protected $db;

	protected $table = 'users';
	protected $primaryKey = 'id';

  protected $returnType = 'object';
  protected $useSoftDeletes = true;

  protected $allowedFields = ['firstname', 'lastname', 'email', 'phone_number', 'city', 'language', 'password', 'password_reset_token', 'password_reset_date', 'active', 'start_turnover', 'turnover'];

  protected $useTimestamps = true;
  protected $dateFormat = 'int';
  protected $createdField  = 'created_at';
  protected $updatedField  = 'updated_at';
  protected $deletedField  = 'deleted_at';

  protected $skipValidation = false;

	protected $validationRules = [
		'firstname' => 'trim|required|min_length[2]|max_length[64]',
		'email' => 'trim|required|max_length[128]|valid_email',
	];

	// we need different rules for register, edit
	protected $dynamicRules = [
		'createUser' => [
			'firstname' => 'trim|required|min_length[2]|max_length[64]',
			'lastname' => 'trim|max_length[64]',
			'email' => 'trim|required|max_length[128]|valid_email|is_unique[users.email]',
			'password' => 'required|min_length[6]',
			'confirm' => 'matches[password]',
			'start_turnover' => 'numeric|required',
			'turnover' => 'numeric|required',
		],
		'editUser' => [
			'firstname' => 'trim|required|min_length[2]|max_length[64]',
			'lastname' => 'trim|max_length[64]',
			'start_turnover' => 'numeric|required',
			'turnover' => 'numeric|required',
		],
		'editUserWithPassword' => [
			'firstname' => 'trim|required|min_length[2]|max_length[64]',
			'lastname' => 'trim|max_length[64]',
			'password' => 'required|min_length[6]',
			'confirm' => 'matches[password]',
			'start_turnover' => 'numeric|required',
			'turnover' => 'numeric|required',
		]
	];

	protected $validationMessages = [];

	protected $allowCallbacks = true;

	// this runs after field validation
	protected $beforeInsert = ['hashPassword'];
	protected $beforeUpdate = ['hashPassword'];

	//--------------------------------------------------------------------

	/**
	* Retrieves all Users data
	*/
	public function getUsers($deleted = false)
	{
		$this->orderBy('id', 'ASC');

		if ($deleted == 'deleted') {
			$result = $this->onlyDeleted()->findAll();
		} else {
			$result = $this->findAll();
		}

		return $result;
	}

	public function getUserByToken($token)
	{
		return $this->where(['password_reset_token' => $token])->first();
	}
	//--------------------------------------------------------------------

	/**
	* Retrieves User data
	*/
	public function getUser($id)
	{
		return $this->where(['id' => $id])->first();
	}

	//--------------------------------------------------------------------

	/**
	* Retrieves User data for pagination and searching
	*/
	public function getElements($deleted = false, $filterData = [])
	{
		$builder = $this->builder();

		if ($deleted == false) {
			$builder->where('deleted_at', null);
		} else {
			$builder->where('deleted_at !=', null);
		}

		if (count($filterData) > 0) {
			$builder->groupStart();
			foreach ($filterData as $key => $value) { 
				$builder->orLike($key, $value);
			}
			$builder->groupEnd();
		}

		//$builder->groupBy('users.id');
		
		// Get the list of users first
		$builder->orderBy('id', 'ASC');

		return $this;
	}

	//--------------------------------------------------------------------

	/**
	* Retrieves User deleted data
	*/

	public function getDeletedElements()
	{
		$this->orderBy('id', 'DESC');

		return $this->onlyDeleted()->findAll();
	}

	//--------------------------------------------------------------------

	/**
	*
	*/
	public function saveUser($data) {
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
	* Retrieves User data
	*/
	public function getOtherUser($id, $myId)
	{
		return $this->where(['id' => $id, 'id !=' => $myId])->first();
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
