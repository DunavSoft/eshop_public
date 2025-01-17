<?php namespace App\Modules\Languages\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddLanguages extends Migration
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
			'side' => [
				'type' => 'VARCHAR',
				'constraint' => 8,
				'null' => true,
				'default' => null,
			],
			'name' => [
				'type' => 'VARCHAR',
				'constraint' => 32,
				'null' => true,
				'default' => null,
			],
			'native_name' => [
				'type' => 'VARCHAR',
				'constraint' => 32,
				'null' => true,
				'default' => null,
			],
			'english_name' => [
				'type' => 'VARCHAR',
				'constraint' => 32,
				'null' => true,
				'default' => null,
			],
			'code' => [
				'type' => 'VARCHAR',
				'constraint' => 8,
				'null' => true,
				'default' => null,
			],
			'uri' => [
				'type' => 'VARCHAR',
				'constraint' => 8,
				'null' => true,
				'default' => null,
			],
			'icon' => [
				'type' => 'VARCHAR',
				'constraint' => 32,
				'null' => true,
				'default' => null,
			],
			'sequence' => [
				'type' => 'TINYINT',
				'constraint' => 1,
				'unsigned' => true,
				'default' => 0,
			],
			'active' => [
				'type' => 'TINYINT',
				'constraint' => 1,
				'unsigned' => true,
				'default' => 0,
			],
			'hidden' => [
				'type' => 'TINYINT',
				'constraint' => 1,
				'unsigned' => true,
				'default' => 0,
			],
			'is_default' => [
				'type' => 'TINYINT',
				'constraint' => 1,
				'unsigned' => true,
				'default' => 0,
			],
		]);

		$this->forge->addKey('id', true);
		$this->forge->addKey('side');
		$this->forge->addKey('uri');
		$this->forge->addKey('hidden');

		$attributes = ['ENGINE' => 'InnoDB'];

		$this->forge->createTable('languages', false, $attributes);

		$this->db->enableForeignKeyChecks();
	}

	public function down()
	{
		$this->db->disableForeignKeyChecks();

		$this->forge->dropTable('languages');

		$this->db->enableForeignKeyChecks();
	}
}
