<?php namespace App\Modules\Properties\Database\Migrations;

/**
 * @version 1.0.0.0
 * @date 2023-04-26
 * @author Georgi Nechovski
 */ 

use CodeIgniter\Database\Migration;

class AddProperties extends Migration
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
			'category_id' => [
				'type' => 'INT',
				'constraint' => '10',
				'unsigned' => true,
				'null' => false,
			],
			'active' => [
				'type' => 'TINYINT',
				'constraint' => '1',
				'unsigned' => true,
				'null' => false,
				'default' => '1',
			],
			'sequence' => [
				'type' => 'SMALLINT',
				'constraint' => 5,
				'unsigned' => true,
				'null' => false,
			],
			'created_at' => [
				'type' => 'INT',
				'constraint' => '32',
				'unsigned' => true,
				'null' => false,
				'default' => '0',
			],
			'updated_at' => [
				'type' => 'INT',
				'constraint' => '32',
				'unsigned' => true,
				'null' => false,
				'default' => '0',
			],
			'deleted_at' => [
				'type' => 'INT',
				'constraint' => '32',
				'unsigned' => true,
				'null' => true,
				'null' => false,
				'default' => null,
			],			
		]);
		
		$this->forge->addKey('id', true);
		$this->forge->addKey('category_id');
		$this->forge->addKey('deleted_at');
		$this->forge->addKey('active');
		
		$this->forge->addForeignKey('category_id', 'properties_categories', 'id', 'CASCADE', 'CASCADE');
		
		$attributes = ['ENGINE' => 'InnoDB'];
		
		$this->forge->createTable('properties', false, $attributes);
		
		$this->db->enableForeignKeyChecks();
	}

	public function down()
	{
		$this->db->disableForeignKeyChecks();
		
		$this->forge->dropTable('properties');
		
		$this->db->enableForeignKeyChecks();
	}
}