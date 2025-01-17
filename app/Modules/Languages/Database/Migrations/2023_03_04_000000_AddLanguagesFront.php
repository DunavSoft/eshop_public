<?php namespace App\Modules\Languages\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddLanguagesFront extends Migration
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
			'lang_variable' => [
				'type' => 'VARCHAR',
				'constraint' => 16,
				'null' => false,
				'default' => null,
			],
			'content' => [
				'type' => 'TEXT',
				'null' => true,
				'default' => null,
			],			
		]);

		$this->forge->addKey('id', true);
		
		$attributes = ['ENGINE' => 'MyISAM']; //or InnoDB 

		$this->forge->createTable('languages_front', false, $attributes);

		$this->db->enableForeignKeyChecks();
	}

	public function down()
	{
		$this->db->disableForeignKeyChecks();

		$this->forge->dropTable('languages_front');

		$this->db->enableForeignKeyChecks();
	}
}
