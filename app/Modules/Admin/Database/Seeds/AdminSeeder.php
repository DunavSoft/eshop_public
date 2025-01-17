<?php
namespace App\Modules\Admin\Database\Seeds;

use CodeIgniter\Database\Seeder;

class AdminSeeder extends Seeder
{
    public function run()
    {
        $data = [
            'firstname' => 'Админ',
            'lastname' => '',
            'email' => 'admin',
            'language' => 'bg',
            'access' => 'Admin',
            'password' => '$2y$10$C/jQo1fOIlzz915agaEDAOs2YuFxhCsSWoGGnCdIqzpwHwr2f75NG',
            'created_at' => time(),
            'updated_at' => time(),
        ];

        $countRecords = $this->db->table('admin')->countAllResults();
		
		if ($countRecords == 0) {
			echo 'Admin Seeder run...';
			$this->db->table('admin')->insert($data);
		}
    }
}