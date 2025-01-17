<?php namespace App\Modules\Pages\Models;

use CodeIgniter\Model;

class PagesModel extends Model
{
	protected $db;
	
	protected $table = 'pages';
	protected $primaryKey = 'id';

    protected $returnType = 'object';
    protected $useSoftDeletes = true;

    protected $allowedFields = ['image', 'image_responsive', 'sequence', 'active'];

    protected $useTimestamps = true;
    protected $dateFormat = 'int';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    protected $skipValidation = false;

	protected $validationRules = [
        'sequence' => [
			'label' => 'AdminPanel.sequence',
			'rules' => 'trim|permit_empty|numeric|max_length[5]',
		],
        'image' => [
			'label' => 'AdminPanel.currentImage',
			'rules' => 'trim',
		],
        'image_responsive' => [
			'label' => 'AdminPanel.currentSecondImage',
			'rules' => 'trim',
		],
	];
	
	public function getFieldData()
    {
        return $this->db->getFieldData($this->table);
    }
	
	/**
	* Retrieves pages data for pagination and searching
	*/
	public function getElements($deleted = false, $filterData = [])
	{
		$builder = $this->builder();

		$builder->select('pages.*, pages_languages.title');
		$builder->join('pages_languages', 'pages_languages.page_id = pages.id', 'left');

		if ($deleted == false) {
			$builder->where('pages.deleted_at', null);
		} else {
			$builder->where('pages.deleted_at !=', null);
		}

		if (count($filterData) > 0) {
			$builder->groupStart();
			foreach ($filterData as $key => $value) {
				$builder->orLike($key, $value);
			}
			$builder->groupEnd();
		}

		// Add group by to prevent duplicates
		$builder->groupBy('pages.id');

		$builder->orderBy('pages.sequence', 'ASC');

		return $builder;
	}

	public function getPages($deleted = 0)
	{
		$this->orderBy('sequence', 'ASC');
		
		if ($deleted == 0) {
			$result = $this->findAll();
		} else {
			$result = $this->onlyDeleted()->findAll();
		}

		return $result;
	}
	
	//Do not use!
	public function getPage($slug)
	{
		return $this->where(['slug' => $slug])->first();
	}
	
	public function getPageById($id)
	{
		return $this->where(['id' => $id])->first();
	}
	
	public function savePage($data) {
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
	
	public function restore($id) {
		$this->allowedFields = ['deleted_at'];
		$this->set('deleted_at', null);
		
		if ($this->update($id) !== false) {
			return true;
		} else {
			return false;
		}
	}
	
	public function savePagesLanguages($data) {
		
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
	
	public function getPagesLanguages($pageID)
	{
		$builder = $this->builder();
		
		$builder->select('pages_languages.*');
		$builder->join('pages_languages', 'pages_languages.page_id = pages.id');
		$builder->join('languages', 'pages_languages.lang_id = languages.id');
		$builder->where('page_id', $pageID);
		$builder->where('languages.active', '1');
		$result = $builder->get()->getResult();

		return $result;
	}
	
	public function getPageLangRowBySiteLanguage($pageID)
	{
		$builder = $this->builder();
		
		$builder->select('pages_languages.*');
		$builder->join('pages_languages', 'pages_languages.page_id = pages.id');
		$builder->join('languages', 'pages_languages.lang_id = languages.id');
		$builder->where('page_id', $pageID);
		$builder->where('languages.side', 'site');
		$builder->where('languages.is_default', '1');
		$builder->where('languages.active', '1');
		
		return $builder->get()->getFirstRow();
	}
	
	/**
	 * Gets pages list together with pages language data, based on locale.
	 * Can be defined active only (languages and pages) or all
	 *
	 * @return object with data from pages + pages_languages tables
	 */
	public function getPagesDataByLocale($locale, $active_only = true, $needle_page = '*', $needle_page_lang = '*')
	{
		$builder = $this->builder('pages_languages');
		
		$builder->select('pages.'. $needle_page .', pages_languages.' . $needle_page_lang);
		$builder->join('pages', 'pages_languages.page_id = pages.id');
		$builder->join('languages', 'pages_languages.lang_id = languages.id');
		$builder->where('languages.code', $locale);
		
		if ($active_only) {
			$builder->where('products_categories.active', '1');
			$builder->where('languages.active', '1');
			$builder->where('pages.active', '1');
			$builder->where('pages.deleted_at', null);
		}

		$builder->orderBy('pages.id', 'ASC');

		return $builder->get()->getResult();
	}
}