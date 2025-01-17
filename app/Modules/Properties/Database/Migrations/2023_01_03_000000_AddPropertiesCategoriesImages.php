<?php namespace App\Modules\Properties\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddPropertiesCategoriesImages extends Migration
{
	public function up()
	{
		$this->db->disableForeignKeyChecks();
		
		$this->forge->addField([
			'id' => [
				'type' => 'INT',
				'constraint' => 10,
				'unsigned' => true,
				'auto_increment' => true,
			],
			'category_id' => [
				'type' => 'INT',
				'constraint' => 10,
				'unsigned' => true,
			],
			'image' => [
				'type' => 'LONGTEXT',
				'null' => true,
				'default' => null,
			],
			'sequence' => [
				'type' => 'INT',
				'constraint' => 5,
				'null' => true,
				'default' => null,
			],
		]);
		
		$this->forge->addKey('id', true);
		$this->forge->addKey('category_id');
		
		$this->forge->addForeignKey('category_id', 'properties_categories', 'id', 'CASCADE', 'CASCADE');
		
		$attributes = ['ENGINE' => 'InnoDB'];
		
		$this->forge->createTable('properties_categories_images', false, $attributes);
		
		$this->db->enableForeignKeyChecks();
	}

	public function down()
	{
		$this->db->disableForeignKeyChecks();
		
		$this->forge->dropTable('properties_categories_images');
		
		$this->db->enableForeignKeyChecks();
	}
}