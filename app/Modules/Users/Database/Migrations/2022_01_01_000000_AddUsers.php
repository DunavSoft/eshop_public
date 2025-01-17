<?php namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddUsers extends Migration
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
			'phone_number' => [
				'type' => 'VARCHAR',
				'constraint' => 24,
				'default' => '',
			],
			'email' => [
				'type' => 'VARCHAR',
				'constraint' => 128,
				'default' => '',
			],
			'phone_number' => [
				'type' => 'VARCHAR',
				'constraint' => 20,
				'default' => '',
			],
			'city' => [
				'type' => 'VARCHAR',
				'constraint' => 255,
				'default' => '',
			],
			'language' => [
				'type' => 'VARCHAR',
				'constraint' => 8,
				'null' => true,
				'default' => null,
			],
			'password' => [
				'type' => 'VARCHAR',
				'constraint' => 60,
				'default' => '',
			],
			'active' => [
				'type' => 'TINYINT',
				'constraint' => 1,
				'unsigned' => true,
				'default' => '1',
			],
			'password_reset_token' => [
				'type' => 'VARCHAR',
				'constraint' => 32,
				'null' => true,
				'default' => true,
			],
			'password_reset_date' => [
				'type' => 'INT',
				'constraint' => 32,
				'unsigned' => true,
				'null' => true,
				'default' => null,
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

		$this->forge->createTable('users', false, $attributes);
	}

	public function down()
	{
		$this->forge->dropTable('users');
	}
}
