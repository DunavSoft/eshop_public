<?php namespace App\Modules\Redirects\Database\Migrations;

/**
 * @version 1.0.0.0
 * @date 2023-03-19
 * @author Georgi Nechovski
 */ 

use CodeIgniter\Database\Migration;

class AddRedirects extends Migration
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
			'source' => [
				'type' => 'VARCHAR',
				'constraint' => '256',
				'null' => false,
			],
			'target' => [
				'type' => 'VARCHAR',
				'constraint' => '256',
				'null' => false,
			],
			'code' => [
				'type' => 'VARCHAR',
				'constraint' => '8',
				'null' => false,
			],
			'count_usage' => [
				'type' => 'INT',
				'constraint' => '32',
				'unsigned' => true,
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
		
		$attributes = ['ENGINE' => 'InnoDB'];
		
		$this->forge->createTable('redirects', false, $attributes);
		
		$this->db->enableForeignKeyChecks();
	}

	public function down()
	{
		$this->db->disableForeignKeyChecks();
		
		$this->forge->dropTable('redirects');
		
		$this->db->enableForeignKeyChecks();
	}
}