<?php

namespace App\Modules\Galleries\Models;

use CodeIgniter\Model;

class GalleriesModel extends Model
{
	protected $db;

	protected $table = 'galleries';
	protected $primaryKey = 'id';

	protected $returnType = 'object';
	protected $useSoftDeletes = true;

	protected $allowedFields = ['active', 'sequence', 'show_home', 'show_list', 'gallery_tag_open', 'gallery_tag_close', 'gallery_element_tag_open', 'gallery_element_tag_close', 'gallery_a_class', 'gallery_image_class'];

	protected $useTimestamps = true;
	protected $dateFormat = 'int';
	protected $createdField  = 'created_at';
	protected $updatedField  = 'updated_at';
	protected $deletedField  = 'deleted_at';

	protected $skipValidation = false;

	protected $validationRules = [
		'active' => 'trim|numeric',
		'sequence' => 'trim|numeric',
	];

	public function getFieldData()
	{
		return $this->db->getFieldData($this->table);
	}

	public function saveGallery($data)
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

	public function getGalleries($deleted = 0, $activeOnly = false)
	{
		$this->orderBy('sequence', 'ASC');

		if ($activeOnly !== false) {
			$this->where('active', '1');
		}

		if ($deleted == 0) {
			$result = $this->findAll();
		} else {
			$result = $this->onlyDeleted()->findAll();
		}

		return $result;
	}

	public function getGalleryBySlug($slug)
	{
		return $this->where(['slug' => $slug])->first();
	}

	public function getGalleryById($id)
	{
		return $this->where(['id' => $id])->first();
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

	public function getGalleryLangRowBySiteLanguage($galleryID)
	{
		$builder = $this->builder();

		$builder->select('galleries_languages.*');
		$builder->join('galleries_languages', 'galleries_languages.gallery_id = galleries.id');
		$builder->join('languages', 'galleries_languages.lang_id = languages.id');
		$builder->where('gallery_id', $galleryID);
		$builder->where('languages.side', 'site');
		$builder->where('languages.is_default', '1');
		$builder->where('languages.active', '1');

		return $builder->get()->getFirstRow();
	}

	public function getGalleryLangRowByAdminLanguage($galleryID)
	{
		$builder = $this->builder();

		$builder->select('galleries_languages.*');
		$builder->join('galleries_languages', 'galleries_languages.gallery_id = galleries.id');
		$builder->join('languages', 'galleries_languages.lang_id = languages.id');
		$builder->where('gallery_id', $galleryID);
		$builder->where('languages.side', 'admin');
		$builder->where('languages.is_default', '1');
		$builder->where('languages.active', '1');

		return $builder->get()->getFirstRow();
	}

	public function getGalleriesLanguages($galleryID)
	{
		$builder = $this->builder();

		$builder->select('galleries_languages.*');
		$builder->join('galleries_languages', 'galleries_languages.gallery_id = galleries.id');
		$builder->join('languages', 'galleries_languages.lang_id = languages.id');
		$builder->where('gallery_id', $galleryID);
		$builder->where('languages.active', '1');
		$result = $builder->get()->getResult();

		return $result;
	}

	/**
	 * Gets galleries list together with galleries language data, based on locale.
	 * Can be defined active only (languages and galleries) or all
	 *
	 * @return object with data from galleries + galleries_languages tables
	 */
	public function getGalleriesDataByLocale($locale, $active_only = true, $needle = '*', $needle_lang = '*')
	{
		$builder = $this->builder('galleries_languages');

		$builder->select('galleries.' . $needle . ', galleries_languages.' . $needle_lang);
		$builder->join('galleries', 'galleries_languages.gallery_id = galleries.id');
		$builder->join('languages', 'galleries_languages.lang_id = languages.id');
		$builder->where('languages.code', $locale);

		if ($active_only) {
			$builder->where('languages.active', '1');
			$builder->where('galleries.active', '1');
			$builder->where('galleries.deleted_at', null);
		}

		return $builder->get()->getResult();
	}

	public function getGalleriesImagesByGalleryIdAndLocale($galleryID, $locale, $active_only = true, $needle = '*', $needle_lang = '*')
	{
		$builder = $this->builder('galleries_languages');

		$builder->select('galleries.' . $needle . ', galleries_languages.' . $needle_lang . ', galleries_images.*');
		$builder->join('galleries', 'galleries_languages.gallery_id = galleries.id');
		$builder->join('languages', 'galleries_languages.lang_id = languages.id');
		$builder->join('galleries_images', 'galleries_images.gallery_id = galleries.id');
		$builder->where('languages.code', $locale);
		$builder->where('galleries.id', $galleryID);
		$builder->where('galleries_images.deleted_at', null);

		if ($active_only) {
			$builder->where('languages.active', '1');
			$builder->where('galleries.active', '1');
			$builder->where('galleries.deleted_at', null);
		}

		$builder->orderBy('galleries_images.sequence', 'ASC');


		return $builder->get()->getResult();
	}

	public function getGalleriesShowHome($locale, $active_only = true, $limit = false, $order = 'ASC', $show = 'show_home', $paginate = false)
	{
		$builder = $this->builder('galleries');

		$builder->select('galleries.*, galleries_languages.title, galleries_languages.meta, galleries_languages.images_description, galleries_languages.slug, routes.slug as route_slug');
		$builder->join('galleries_languages', 'galleries_languages.gallery_id = galleries.id');
		//$builder->join('galleries_images', 'galleries_images.gallery_id = galleries.id');
		$builder->join('languages', 'galleries_languages.lang_id = languages.id');
		$builder->join('routes', 'galleries_languages.route_id = routes.id');
		$builder->where('languages.code', $locale);
		$builder->where('galleries.' . $show, '1');

		if ($active_only) {
			$builder->where('languages.active', '1');
			$builder->where('galleries.active', '1');
			$builder->where('galleries.deleted_at', null);
			//$builder->where('galleries_images.deleted_at', null);
		}

		$builder->groupBy('galleries.id');

		$builder->orderBy('galleries.id', $order);
		$builder->orderBy('galleries.id', 'ASC');

		if ($limit !== false) {
			$builder->limit($limit);
		}

		//return $builder->getCompiledSelect(); 

		if ($paginate === true) {
			return $this;
		} else {
			return $builder->get()->getResult();
		}
	}
}