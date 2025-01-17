<?php namespace App\Modules\Galleries\Database\Migrations;

use CodeIgniter\Database\Migration;

class ModifyGalleriesLang extends Migration
{
	public function up()
	{
		$this->db->disableForeignKeyChecks();
		
		$this->forge->addColumn('galleries_languages',[
            'seo_title' => [
				'type' => 'TEXT',
				'null' => false,
                'after' => 'title',
			],
            'meta' => [
				'type' => 'TEXT',
				'null' => false,
                'after' => 'seo_title',
			],
        ]);
        
        $this->db->enableForeignKeyChecks();
	}

	public function down()
	{
		$this->db->disableForeignKeyChecks();
		
		$this->db->enableForeignKeyChecks();
	}
}