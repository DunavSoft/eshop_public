<?php namespace App\Modules\Properties\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddPropertiesCategories extends Migration
{
	public function up()
	{
		$this->db->disableForeignKeyChecks();

		$this->forge->addField([
			'id' => [
				'type' => 'INT',
				'constraint' => '10',
				'unsigned' => true,
				'auto_increment' => true,
			],
			'active' => [
				'type' => 'TINYINT',
				'constraint' => '1',
				'unsigned' => true,
				'default' => '1',
			],
			'multiple_choice' => [
				'type' => 'TINYINT',
				'constraint' => 1,
				'null' => true,
				'default' => null
			],
			'in_filter' => [
				'type' => 'TINYINT',
				'constraint' => 1,
				'null' => true,
				'default' => null
			],
			'created_at' => [
				'type' => 'INT',
				'constraint' => '32',
				'unsigned' => true,
				'null' => true,
				'default' => null,
			],
			'updated_at' => [
				'type' => 'INT',
				'constraint' => '32',
				'unsigned' => true,
				'null' => true,
				'default' => null,
			],
			'deleted_at' => [
				'type' => 'INT',
				'constraint' => '32',
				'unsigned' => true,
				'null' => true,
				'default' => null,
			],
		]);

		$this->forge->addKey('id', true);
		$this->forge->addKey('deleted_at');

		$attributes = ['ENGINE' => 'InnoDB'];

		$this->forge->createTable('properties_categories', false, $attributes);

		$this->db->enableForeignKeyChecks();
	}

	public function down()
	{
		$this->db->disableForeignKeyChecks();

		$this->forge->dropTable('properties_categories');

		$this->db->enableForeignKeyChecks();
	}
}
