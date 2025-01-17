<?php namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddAdmin extends Migration
{
	public function up()
	{
		$this->forge->addField([
			'id' => [
				'type' => 'INT',
				'constraint' => 10,
				'unsigned' => true,
				'auto_increment' => true,
			],
			'firstname' => [
				'type' => 'VARCHAR',
				'constraint' => 64,
				'default' => '',
			],
			'lastname' => [
				'type' => 'VARCHAR',
				'constraint' => 64,
				'default' => '',
			],
			'email' => [
				'type' => 'VARCHAR',
				'constraint' => 128,
				'default' => '',
			],
			'language' => [
				'type' => 'VARCHAR',
				'constraint' => 8,
				'default' => '',
			],			
			'access' => [
				'type' => 'VARCHAR',
				'constraint' => 20,
				'default' => '',
			],
			'password' => [
				'type' => 'VARCHAR',
				'constraint' => 60,
				'default' => '',
			],
			'created_at' => [
				'type' => 'INT',
				'constraint' => 32,
				'unsigned' => true,
				'null' => true,
				'default' => null,
			],
			'updated_at' => [
				'type' => 'INT',
				'constraint' => 32,
				'unsigned' => true,
				'null' => true,
				'default' => null,
			],
			'deleted_at' => [
				'type' => 'INT',
				'constraint' => 32,
				'unsigned' => true,
				'null' => true,
				'default' => null,
			],
		]);
		
		$this->forge->addKey('id', true);

		$attributes = ['ENGINE' => 'InnoDB'];

		$this->forge->createTable('admin', false, $attributes);
	}

	public function down()
	{
		$this->forge->dropTable('admin');
	}
}