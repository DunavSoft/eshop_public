<?php namespace App\Modules\Users\Models;

use CodeIgniter\Model;

class SubscriptionsModel extends Model
{
	protected $db;

	protected $table = 'subscriptions';
	protected $primaryKey = 'id';

	protected $returnType = 'object';
	protected $dateFormat = 'int';

	protected $createdField  = 'created_at';
	protected $updatedField  = 'updated_at';
	protected $deletedField  = 'deleted_at';

	protected $useSoftDeletes = false;
	protected $useTimestamps = true;
	protected $skipValidation = false;
	protected $allowCallbacks = true;

	protected $allowedFields = ['id' ,'email', 'name', 'phone', 'active', 'token'];

	protected $validationMessages = [];
	protected $validationRules = [
		'email' => [
			'label' => 'SubscriptionsLang.email',
			'rules' => 'valid_email|required',
		],
	];
	
	/**
	* Retrieves all subscriptions data
	*/
	public function getSubscriptions($deleted = false)
	{
		$this->orderBy('id', 'DESC');

		if ($deleted == 'deleted') {
			$result = $this->onlyDeleted()->findAll();
		} else {
			$result = $this->findAll();
		}

		return $result;
	}
	
	/**
	* Retrieves subscriptions data with pagination
	*/
	public function getSubscriptionsPaginate($deleted = false)
	{
		$this->orderBy('id', 'DESC');

		if ($deleted == 'deleted') {
			$this->where('deleted_at', null);
		}

		return $this;
	}

	/**
	* Retrieves subscription data
	*/
	public function getSubscription($id)
	{
		return $this->where(['id' => $id])->first();
	}

	/**
	* Saves subscription data
	*/
	public function saveSubscribtion($data) 
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
	
	/**
	 * Insert or Update based on email.
	 */
	public function insertOrUpdateSubscribtion($data)
	{
		$query = $this->where('email', $data['email'])->first();

		if (!$query) {
			// Record does not exist, insert
			return $this->insert($data, true);
		} else {
			// Record exists, update
			unset($data['token']);
			return $this->update($query->id, $data);
		}
	}

	/**
	* Retrieves all subscriptions by article ID to which no emails have been sent
	*/
	public function getSubscriptionsByArticleId($article_id)
	{
		return $this->where(
			[
				'article_id' => $article_id,
				'deleted_at' => NULL
			]
		)->findAll();
	}

	/**
	* Set subscruption send flag to true
	*/
	public function updateSubscriptionSentFlag($id) 
	{
		$this->allowedFields = ['deleted_at'];
		$this->set('deleted_at', time());

		if ($this->update($id) !== false) {
			return true;
		} else {
			return false;
		}
	}
	
	/**
	* Retrieves subscription by token
	*/
	public function getSubscriptionByToken($token)
	{
		return $this->where(['token' => $token])->first();
	}
	
	public function searchElements($searchArray)
	{
		$builder = $this->builder();

		$builder->orderBy('id', 'DESC');
		
		if ($searchArray != false) {
			$builder->groupStart();
			foreach ($searchArray as $key => $value) {
				$builder->orLike($key, $value);
			}
			$builder->groupEnd();
		}
		
		//echo $builder->getCompiledSelect(false);
		return $this;
	}
}
