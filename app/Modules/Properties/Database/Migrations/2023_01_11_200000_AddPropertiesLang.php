<?php namespace App\Modules\Properties\Database\Migrations;

/**
 * @version 1.0.0.0
 * @date 2023-04-26
 * @author Georgi Nechovski
 */ 
 
use CodeIgniter\Database\Migration;

class AddPropertiesLang extends Migration
{
	public function up()
	{
		$this->db->disableForeignKeyChecks();
		
		$this->forge->addField([
			'id' => [
				'type' => 'INT',
				'constraint' => '10',
				'unsigned' => true,
				'null' => false,
				'auto_increment' => true,
			],
			'lang_id' => [
				'type' => 'INT',
				'constraint' => '10',
				'unsigned' => true,
				'null' => false,
			],
			'property_id' => [
				'type' => 'INT',
				'constraint' => '10',
				'unsigned' => true,
				'null' => false,
			],
			'title' => [
				'type' => 'VARCHAR',
				'constraint' => 512,
				'null' => true,
				'default' => null
			],
			'content' => [
				'type' => 'TEXT',
				'null' => true,
				'default' => null
			],
			'images_description' => [
				'type' => 'TEXT',
				'null' => true,
				'default' => null,
			],
			'route_id' => [
				'type' => 'INT',
				'constraint' => 10,
				'unsigned' => true,
				'null' => true,
				'default' => null
			],
		]);

		$this->forge->addKey('id', true);
		$this->forge->addKey('lang_id');
		$this->forge->addKey('property_id');
		$this->forge->addKey('route_id');

		$this->forge->addForeignKey('property_id', 'properties', 'id', 'CASCADE', 'CASCADE');
		$this->forge->addForeignKey('lang_id', 'languages', 'id', 'CASCADE', 'CASCADE');
		$this->forge->addForeignKey('route_id', 'routes', 'id', 'CASCADE', 'CASCADE');

		$attributes = ['ENGINE' => 'InnoDB'];

		$this->forge->createTable('properties_languages', false, $attributes);

		$this->db->enableForeignKeyChecks();
	}

	public function down()
	{
		$this->db->disableForeignKeyChecks();
		
		$this->forge->dropTable('properties_languages');
		
		$this->db->enableForeignKeyChecks();
	}
}
