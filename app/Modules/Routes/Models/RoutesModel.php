<?php namespace App\Modules\Routes\Models;

use CodeIgniter\Model;

class RoutesModel extends Model
{
    protected $table = 'routes';
    protected $primaryKey = 'id';

    protected $returnType = 'object';
    protected $useSoftDeletes = false;
    
    protected $allowedFields = ['slug', 'route'];

    protected $useTimestamps = true;
    protected $dateFormat = 'int';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';

    public function findBySlug($slug)
    {
        return $this->where('slug', $slug)->first();
    }
}