<?php namespace App\Modules\Galleries\Models;

use CodeIgniter\Model;

class GalleriesImagesModel extends Model
{
	protected $db;
	
	protected $table = 'galleries_images';
	protected $primaryKey = 'id';

    protected $returnType = 'object';
    protected $useSoftDeletes = true;

    protected $allowedFields = ['id', 'gallery_id', 'image', 'sequence'];

   // protected $useTimestamps = true;
    protected $dateFormat = 'int';
    protected $deletedField  = 'deleted_at';
    protected $skipValidation = true;

	public function getArrayImagesByGalleryId($galleryId)
	{
		$return = [];
		$_result = $this->where(['gallery_id' => $galleryId])->findAll();
		
		//TODO
		foreach ($_result as $element) {
			$return[$element->category_id] = $element->gallery_id;
		}
		
		return $return;
	}
	
	public function getImagesByGalleryId($galleryId)
	{
		return $this->where(['gallery_id' => $galleryId])->orderBy('sequence', 'ASC')->findAll();
	}
	
	public function getPrimaryImagesByGalleryId($galleryId)
	{
		return $this->where(['gallery_id' => $galleryId])->orderBy('sequence', 'ASC')->first();
	}
	
	public function saveGalleryImage($data) {
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