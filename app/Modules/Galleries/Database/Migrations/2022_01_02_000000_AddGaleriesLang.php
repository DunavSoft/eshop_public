<?php namespace App\Modules\Galleries\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddGaleriesLang extends Migration
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
			'lang_id' => [
				'type' => 'INT',
				'constraint' => 10,
				'unsigned' => true,
				'null' => true,
				'default' => null,
			],
			'gallery_id' => [
				'type' => 'INT',
				'constraint' => 10,
				'unsigned' => true,
				'null' => true,
				'default' => null,
			],
			'route_id' => [
				'type' => 'INT',
				'constraint' => 10,
				'unsigned' => true,
				'null' => true,
				'default' => null,
			],	
			'title' => [
				'type' => 'VARCHAR',
				'constraint' => 256,
				'null' => true,
				'default' => null,
			],
			'content' => [
				'type' => 'TEXT',
				'null' => true,
				'default' => null,
			],
			'images_description' => [
				'type' => 'TEXT',
				'null' => true,
				'default' => null,
			],
			'slug' => [
				'type' => 'VARCHAR',
				'constraint' => 256,
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
		$this->forge->addKey('lang_id');
		$this->forge->addKey('gallery_id');
		$this->forge->addKey('route_id');
		$this->forge->addKey('deleted_at');
		
		$this->forge->addForeignKey('gallery_id', 'galleries', 'id', 'CASCADE', 'CASCADE');
		$this->forge->addForeignKey('lang_id', 'languages', 'id', 'CASCADE', 'CASCADE');
		$this->forge->addForeignKey('route_id', 'routes', 'id', 'CASCADE', 'CASCADE');
		
		$attributes = ['ENGINE' => 'InnoDB'];
		
		$this->forge->createTable('galleries_languages', false, $attributes);
		
		$this->db->enableForeignKeyChecks();
	}

	public function down()
	{
		$this->db->disableForeignKeyChecks();
		
		$this->db->enableForeignKeyChecks();
	}
}