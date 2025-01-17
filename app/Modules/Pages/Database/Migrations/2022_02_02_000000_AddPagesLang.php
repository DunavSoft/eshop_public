<?php namespace App\Modules\Pages\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddPagesLang extends Migration
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
			'page_id' => [
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
				'null' => false,
			],
			'seo_title' => [
				'type' => 'TEXT',
				'null' => false,
			],
			'meta' => [
				'type' => 'TEXT',
				'null' => false,
			],
			'content' => [
				'type' => 'LONGTEXT',
				'null' => false,
			],
			'img_alt' => [
				'type' => 'VARCHAR',
				'constraint' => 256,
				'null' => false,
			],
			'img_title' => [
				'type' => 'VARCHAR',
				'constraint' => 256,
				'null' => false,
			],
			'resp_img_alt' => [
				'type' => 'VARCHAR',
				'constraint' => 256,
				'null' => false,
			],
			'resp_img_title' => [
				'type' => 'VARCHAR',
				'constraint' => 256,
				'null' => false,
			],
			'slug' => [
				'type' => 'VARCHAR',
				'constraint' => 256,
				'null' => false,
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
		$this->forge->addKey('page_id');
		$this->forge->addKey('route_id');
		$this->forge->addKey('deleted_at');

		$this->forge->addForeignKey('page_id', 'pages', 'id', 'CASCADE', 'CASCADE');
		$this->forge->addForeignKey('lang_id', 'languages', 'id', 'CASCADE', 'CASCADE');
		$this->forge->addForeignKey('route_id', 'routes', 'id', 'CASCADE', 'CASCADE');

		$attributes = ['ENGINE' => 'InnoDB'];

		$this->forge->createTable('pages_languages', false, $attributes);

		$this->db->enableForeignKeyChecks();
	}

	public function down()
	{
		$this->db->disableForeignKeyChecks();

		$this->db->enableForeignKeyChecks();
	}
}