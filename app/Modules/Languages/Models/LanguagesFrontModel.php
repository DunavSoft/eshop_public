<?php namespace App\Modules\Languages\Models;

use CodeIgniter\Model;

class LanguagesFrontModel extends Model
{
	protected $db;
	
	protected $table = 'languages_front';
	protected $primaryKey = 'id';

    protected $returnType = 'object';
    protected $useSoftDeletes = false;

    protected $allowedFields = ['lang_variable', 'content'];
/*
    protected $useTimestamps = true;
    protected $dateFormat = 'int';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';
*/
    protected $skipValidation = false;

	protected $validationRules = [
        'lang_variable' => 'trim|required',
        'content' => 'trim',
    ];
	
	
	public function getElements($side = 'admin')
	{
		$this->orderBy('is_default', 'DESC');
		$this->orderBy('active', 'DESC');
		$this->orderBy('sequence', 'ASC');
		$this->where('side', $side);
		
		$result = $this->findAll();
		
		return $result;
	}
	
	/*
	public function getActiveElements($side = 'admin')
	{
		$this->orderBy('is_default', 'DESC');
		$this->orderBy('sequence', 'ASC');
		$this->where('side', $side);
		$this->where('active', '1');
		
		$result = $this->findAll();
		
		return $result;
	}
	*/
	
	public function getElement($side, $uri)
	{
		return $this->where(['side' => $side, 'uri' => $uri])->first();
	}
	
	public function getDefaultSiteLanguage()
	{
		return $this->where(['side' => 'site', 'is_default' => '1'])->first();
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
}