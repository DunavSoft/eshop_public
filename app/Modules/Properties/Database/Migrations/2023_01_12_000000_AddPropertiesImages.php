<?php namespace App\Modules\Properties\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddPropertiesImages extends Migration
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
			'property_id' => [
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
		$this->forge->addKey('property_id');
		
		$this->forge->addForeignKey('property_id', 'properties', 'id', 'CASCADE', 'CASCADE');
		
		$attributes = ['ENGINE' => 'InnoDB'];
		
		$this->forge->createTable('properties_images', false, $attributes);
		
		$this->db->enableForeignKeyChecks();
	}

	public function down()
	{
		$this->db->disableForeignKeyChecks();
		
		$this->forge->dropTable('properties_images');
		
		$this->db->enableForeignKeyChecks();
	}
}