<?php namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddRoutes extends Migration
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
			'slug' => [
				'type' => 'VARCHAR',
				'constraint' => 256,
				'null' => true,
				'default' => null
			],
			'route' => [
				'type' => 'TEXT',
				'null' => true,
				'default' => null
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
		]);
		
		$this->forge->addKey('id', true);

		$attributes = ['ENGINE' => 'InnoDB'];

		$this->forge->createTable('routes', false, $attributes);

        $this->db->enableForeignKeyChecks();
	}

	public function down()
	{
		$this->db->disableForeignKeyChecks();

        $this->db->enableForeignKeyChecks();
	}
}