<?php namespace App\Modules\Properties\Database\Migrations;

/**
 * @version 1.2.0.0
 * @date 2023-06-23
 * @author Georgi Nechovski
 */ 
 
use CodeIgniter\Database\Migration;

class UpdatesPropertiesCategories extends Migration
{
	public function up()
	{
		$this->db->disableForeignKeyChecks();
		
		$fields = [
			'sequence' => [
				'type' => 'SMALLINT',
				'constraint' => 5,
				'unsigned' => true,
				'null' => false,
				'after' => 'active',
			],
		];

		$this->forge->addColumn('properties_categories', $fields);
		
		$query = "ALTER TABLE properties_categories ADD INDEX sequence (sequence); ";

		$this->db->query($query);

		$this->db->enableForeignKeyChecks();
	}

	public function down()
	{
		$this->db->disableForeignKeyChecks();
		
		$this->db->enableForeignKeyChecks();
	}
}
