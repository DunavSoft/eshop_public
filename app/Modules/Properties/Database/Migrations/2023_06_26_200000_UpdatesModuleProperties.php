<?php namespace App\Modules\Properties\Database\Migrations;

/**
 * @version 1.3.0.0
 * @date 2023-06-26
 * @author Georgi Nechovski
 */ 
 
use CodeIgniter\Database\Migration;

class UpdatesModuleProperties extends Migration
{
	public function up()
	{
		$this->db->disableForeignKeyChecks();
		
		$fields = [
			'slug' => [
				'type' => 'VARCHAR',
				'constraint' => 256,
				'null' => false,
			],
		];

		$this->forge->addColumn('properties_categories_languages', $fields);
		
		$query = "ALTER TABLE properties_categories_languages ADD INDEX slug (slug); ";

		$this->db->query($query);

		$this->forge->addColumn('properties_languages', $fields);
		
		$query = "ALTER TABLE properties_languages ADD INDEX slug (slug); ";

		$this->db->query($query);

		$this->db->enableForeignKeyChecks();
	}

	public function down()
	{
		$this->db->disableForeignKeyChecks();
		
		$this->db->enableForeignKeyChecks();
	}
}
