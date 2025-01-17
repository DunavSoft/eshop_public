<?php namespace App\Modules\Distributors\Database\Migrations;

/**
 * @version 1.0.0.0
 * @date 2023-03-29
 * @author Georgi Nechovski
 */ 
 
use CodeIgniter\Database\Migration;

class AddColorsLang extends Migration
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
			'lang_id' => [
				'type' => 'INT',
				'constraint' => '10',
				'unsigned' => true,
				'null' => false,
			],
			'color_id' => [
				'type' => 'INT',
				'constraint' => '10',
				'unsigned' => true,
				'null' => false,
			],
			'title' => [
				'type' => 'VARCHAR',
				'constraint' => '256',
				'null' => false,
			],
			'images_description' => [
				'type' => 'TEXT',
				'null' => true,
				'default' => null,
			],
		]);

		$this->forge->addKey('id', true);
		$this->forge->addKey('lang_id');
		$this->forge->addKey('color_id');

		$this->forge->addForeignKey('color_id', 'colors', 'id', 'CASCADE', 'CASCADE');
		$this->forge->addForeignKey('lang_id', 'languages', 'id', 'CASCADE', 'CASCADE');

		$attributes = ['ENGINE' => 'InnoDB'];

		$this->forge->createTable('colors_languages', false, $attributes);

		$this->db->enableForeignKeyChecks();
	}

	public function down()
	{
		$this->db->disableForeignKeyChecks();
		
		$this->forge->dropTable('colors_languages');
		
		$this->db->enableForeignKeyChecks();
	}
}
