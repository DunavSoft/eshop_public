<?php

namespace App\Modules\Redirects\Models;

use CodeIgniter\Model;

class RedirectsModel extends Model
{
	protected $db;

	protected $table = 'redirects';
	protected $primaryKey = 'id';

	protected $returnType = 'object';
	protected $useSoftDeletes = true;

	protected $allowedFields = ['source', 'target', 'code', 'count_usage'];

	protected $useTimestamps = true;
	protected $dateFormat = 'int';
	protected $createdField  = 'created_at';
	protected $updatedField  = 'updated_at';
	protected $deletedField  = 'deleted_at';

	protected $skipValidation = false;

	protected $validationRules = [
		'source' => 'trim|required|max_length[256]',
		'target' => 'trim|required|max_length[256]|differs[source]',
		'code' => 'trim|required|max_length[8]',
	];


	public function getFieldData()
	{
		return $this->db->getFieldData($this->table);
	}

	 
	public function getElements()
	{
		$builder = $this->builder();

		$builder->orderBy('id', 'DESC');

		$builder->where('deleted_at', null);

		$result = $builder->get()->getResultObject();
		//echo $builder->getCompiledSelect(false);exit;

		return $result; // This will allow the call chain to be used.
	}

	//using pagination
	public function getElementsPaginate()
	{
		$builder = $this->builder();

		$builder->orderBy('id', 'DESC');

		$builder->where('deleted_at', null);

		//echo $builder->getCompiledSelect(false);exit;

		return $this; // This will allow the call chain to be used.
	}

	public function getDeletedElements()
	{
		$this->orderBy('id', 'DESC');

		return $this->onlyDeleted()->findAll();
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

	public function searchRedirectsByArray($searchArray)
	{
		$builder = $this->builder();

		$builder->select('*');
		$builder->where('deleted_at', null);

		$builder->groupStart();
		foreach ($searchArray as $key => $value) {
			$builder->orLike($key, $value);
		}
		$builder->groupEnd();

		//echo $builder->getCompiledSelect(false);
		return $this;
	}
}
