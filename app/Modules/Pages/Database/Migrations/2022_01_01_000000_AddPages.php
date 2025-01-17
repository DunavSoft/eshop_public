<?php namespace App\Modules\Pages\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddPages extends Migration
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
			'image' => [
				'type' => 'LONGTEXT',
				'null' => true,
				'default' => null,
			],
			'image_responsive' => [
				'type' => 'LONGTEXT',
				'null' => true,
				'default' => null,
			],
			'sequence' => [
				'type' => 'SMALLINT',
				'constraint' => 5,
				'unsigned' => true,
				'null' => false,
				'default' => '1',
			],
			'active' => [
				'type' => 'TINYINT',
				'constraint' => 1,
				'unsigned' => true,
				'null' => false,
				'default' => '1',
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
		$this->forge->addKey('deleted_at');
		$this->forge->addKey('active');
		$this->forge->addKey('sequence');

		$attributes = ['ENGINE' => 'InnoDB'];

		$this->forge->createTable('pages', false, $attributes);

		$this->db->enableForeignKeyChecks();
	}

	public function down()
	{
		$this->db->disableForeignKeyChecks();
		
		$this->db->enableForeignKeyChecks();
	}
}