<?php namespace App\Modules\Galleries\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddGalleries extends Migration
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
			'active' => [
				'type' => 'TINYINT',
				'constraint' => 1,
				'unsigned' => true,
				'default' => '1',
			],
			'sequence' => [
				'type' => 'SMALLINT',
				'constraint' => 5,
				'null' => true,
				'default' => null,
			],
			'gallery_tag_open' => [
				'type' => 'VARCHAR',
				'constraint' => 256,
				'null' => true,
				'default' => null,
			],
			'gallery_tag_close' => [
				'type' => 'VARCHAR',
				'constraint' => 16,
				'null' => true,
				'default' => null,
			],
			'gallery_element_tag_open' => [
				'type' => 'VARCHAR',
				'constraint' => 256,
				'null' => true,
				'default' => null,
			],
			'gallery_element_tag_close' => [
				'type' => 'VARCHAR',
				'constraint' => 16,
				'null' => true,
				'default' => null,
			],
			'gallery_a_class' => [
				'type' => 'VARCHAR',
				'constraint' => 256,
				'null' => true,
				'default' => null,
			],
			'gallery_image_class' => [
				'type' => 'VARCHAR',
				'constraint' => 256,
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
		$this->forge->addKey('active');
		$this->forge->addKey('sequence');
		$this->forge->addKey('deleted_at');
		
		$attributes = ['ENGINE' => 'InnoDB'];
		
		$this->forge->createTable('galleries', false, $attributes);
		
		$this->db->enableForeignKeyChecks();
	}

	public function down()
	{
		$this->db->disableForeignKeyChecks();
		
		$this->db->enableForeignKeyChecks();
	}
}