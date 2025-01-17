<?php namespace App\Modules\Galleries\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddGalleriesImages extends Migration
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
			'gallery_id' => [
				'type' => 'INT',
				'constraint' => 10,
				'unsigned' => true,
			],		
			'image' => [
				'type' => 'LONGTEXT',
				'null' => true,
				'default' => null,
			],		
			'sequence' => [
				'type' => 'INT',
				'constraint' => 5,
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
		$this->forge->addKey('gallery_id');
		$this->forge->addKey('deleted_at');
		
		$this->forge->addForeignKey('gallery_id', 'galleries', 'id', 'CASCADE', 'CASCADE');
		
		$attributes = ['ENGINE' => 'InnoDB'];
		
		$this->forge->createTable('galleries_images', false, $attributes);
		
		$this->db->enableForeignKeyChecks();
	}

	public function down()
	{
		$this->db->disableForeignKeyChecks();
		
		$this->db->enableForeignKeyChecks();
	}
}