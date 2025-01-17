<?php namespace App\Modules\Colors\Database\Migrations;

/**
 * @version 1.0.0.0
 * @date 2023-03-29
 * @author Georgi Nechovski
 */ 

use CodeIgniter\Database\Migration;

class AddColors extends Migration
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
			'image' => [
				'type' => 'LONGTEXT',
				'null' => true,
				'default' => null,
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
		$this->forge->addKey('deleted_at');
		$this->forge->addKey('active');
		
		$attributes = ['ENGINE' => 'InnoDB'];
		
		$this->forge->createTable('colors', false, $attributes);
		
		$this->db->enableForeignKeyChecks();
	}

	public function down()
	{
		$this->db->disableForeignKeyChecks();
		
		$this->forge->dropTable('colors');
		
		$this->db->enableForeignKeyChecks();
	}
}