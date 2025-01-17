<?php

namespace App\Modules\Galleries\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddGalleriesShow extends Migration
{
	public function up()
	{
		$this->db->disableForeignKeyChecks();

		$fields = [
			'show_home' => [
				'type' => 'TINYINT',
				'constraint' => 1,
				'unsigned' => true,
				'null' => false,
				'default' => 0,
                'after' => 'sequence'
			],
			'show_list' => [
				'type' => 'TINYINT',
				'constraint' => 1,
				'unsigned' => true,
				'null' => false,
				'default' => 0,
                'after' => 'show_home'
			],
		];
        
		$this->forge->addColumn('galleries', $fields);

		$this->db->enableForeignKeyChecks();
	}

	public function down()
	{
		$this->db->disableForeignKeyChecks();

		$this->db->enableForeignKeyChecks();
	}
}
       
            
            
            
            
            
            
            
            
            
            
            
            
            
            
            