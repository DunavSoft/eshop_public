<?php namespace App\Modules\Properties\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddPropertiesCategoriesLang extends Migration
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
			'lang_id' => [
				'type' => 'INT',
				'constraint' => 10,
				'unsigned' => true,
			],
			'category_id' => [
				'type' => 'INT',
				'constraint' => 10,
				'unsigned' => true,
			],
			'title' => [
				'type' => 'VARCHAR',
				'constraint' => 512,
				'null' => true,
				'default' => null,
			],
			'content' => [
				'type' => 'TEXT',
				'null' => true,
				'default' => null,
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
		$this->forge->addKey('category_id');
		$this->forge->addKey('slug');
		$this->forge->addKey('route_id');
		
		$this->forge->addForeignKey('category_id', 'properties_categories', 'id', 'CASCADE', 'CASCADE');
		$this->forge->addForeignKey('lang_id', 'languages', 'id', 'CASCADE', 'CASCADE');
		$this->forge->addForeignKey('route_id', 'routes', 'id', 'CASCADE', 'CASCADE');

		$attributes = ['ENGINE' => 'InnoDB'];

		$this->forge->createTable('properties_categories_languages', false, $attributes);

		$this->db->enableForeignKeyChecks();
	}

	public function down()
	{
		$this->db->disableForeignKeyChecks();

		$this->forge->dropTable('properties_categories_languages');

		$this->db->enableForeignKeyChecks();
	}
}