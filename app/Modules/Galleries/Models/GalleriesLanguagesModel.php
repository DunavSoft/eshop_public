<?php namespace App\Modules\Galleries\Models;

use CodeIgniter\Model;

class GalleriesLanguagesModel extends Model
{
	protected $db;
	
	protected $table = 'galleries_languages';
	protected $primaryKey = 'id';

    protected $returnType = 'object';
    protected $useSoftDeletes = true;

    protected $allowedFields = ['title', 'lang_id', 'gallery_id', 'route_id', 'content', 'images_description', 'slug', 'seo_title', 'meta'];

    protected $useTimestamps = false;
    protected $dateFormat = 'int';
   
    protected $skipValidation = false;

	protected $validationRules = [
		'title' => 'trim|required|max_length[256]',
        'content' => 'trim',
        'slug' => 'trim|max_length[256]',
		'seo_title' => 'trim',
        'meta' => 'trim',
    ];
	
	public function saveGalleriesLanguages($data)
	{
		$existElement = $this->_getGalleriesLanguages($data['lang_id'], $data['gallery_id']);
		
		if ($existElement !== null) {
			$data['id'] = $existElement->id;
		}
		
		return $this->save($data);
	}
	
	private function _getGalleriesLanguages($langID, $galleryID)
	{
		return $this->where(['lang_id' => $langID, 'gallery_id' => $galleryID])->first();
	}
	
	public function getGalleryLanguage($langID, $galleryID)
	{
		return $this->where(['lang_id' => $langID, 'gallery_id' => $galleryID])->first();
	}
	
	public function getGallery($slug, $locale)
	{
		$builder = $this->builder('galleries');
		
		$builder->select('galleries.*, galleries_languages.*, galleries_images.*, routes.slug as route_slug');
		$builder->join('galleries_languages', 'galleries_languages.gallery_id = galleries.id');
		$builder->join('galleries_images', 'galleries_images.gallery_id = galleries.id', 'left');
		$builder->join('languages', 'galleries_languages.lang_id = languages.id');
		$builder->join('routes', 'galleries_languages.route_id = routes.id');
		$builder->where('routes.slug', $slug);
		$builder->where('languages.active', '1');
		$builder->where('galleries.active', '1');
		$builder->where('galleries.deleted_at', null);
		$builder->where('languages.code', $locale);
		$builder->where('galleries_images.deleted_at', null);
		
		$builder->orderBy('galleries_images.sequence', 'ASC');
		
		$result = $builder->get()->getResult();
		
		return $result;
	}
	
	public function getGalleriesLanguages()
	{
		$builder = $this->builder();
		
		$builder->select('galleries_languages.*');
		$builder->join('galleries', 'galleries_languages.gallery_id = galleries.id');
		$builder->join('languages', 'galleries_languages.lang_id = languages.id');
		$builder->where('languages.active', '1');
		$result = $builder->get()->getResult();

		return $result;
	}
	
	public function getGalleriessLangSlugs($locale) : array
	{
		$builder = $this->builder();
		
		$builder->select('galleries_languages.slug, galleries_languages.gallery_id, galleries.active');
		$builder->join('galleries', 'galleries_languages.gallery_id = galleries.id');
		$builder->join('languages', 'galleries_languages.lang_id = languages.id');
		$builder->where('languages.active', '1');
		$builder->where('languages.code', $locale);
		$builder->where('galleries.active', '1');
		$result = $builder->get()->getResult();
		
		$returnArray = [];
		foreach ($result as $element) {
			$returnArray[$element->gallery_id] = $element->slug;
		}
		
		return $returnArray;
	}

	public function getGalleries($locale)
	{
		$builder = $this->builder();

		$builder->select('galleries_languages.*');
		$builder->join('galleries', 'galleries_languages.gallery_id = galleries.id');
		$builder->join('languages', 'galleries_languages.lang_id = languages.id');

		$builder->where('languages.active', '1');
		$builder->where('languages.code', $locale);
		$builder->where('galleries.active', '1');
		$builder->where('galleries.deleted_at', null);
		
		$builder->orderBy('galleries.sequence', 'ASC');

		return $builder->get()->getResult();
	}
}