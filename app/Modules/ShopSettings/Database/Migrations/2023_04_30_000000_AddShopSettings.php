<?php namespace App\Modules\ShopSettings\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddShopSettings extends Migration
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
			'setup_key' => [
				'type' => 'VARCHAR',
				'constraint' => 256,
				'null' => false,
				'default' => '',
			],			
			'setup_value' => [
				'type' => 'TEXT',
				'null' => true,
				'default' => null,
			],
			'locale' => [
				'type' => 'VARCHAR',
				'constraint' => 8,
				'null' => false,
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
		$this->forge->addKey('locale');
		
		$this->forge->addForeignKey('locale', 'languages', 'uri', 'CASCADE', 'CASCADE');
		
		$attributes = ['ENGINE' => 'InnoDB'];

		$this->forge->createTable('shopsettings', false, $attributes);

		$this->db->enableForeignKeyChecks();		
	}

	public function down()
	{
		$this->db->disableForeignKeyChecks();
		
		$this->forge->dropTable('shopsettings');
		
		$this->db->enableForeignKeyChecks();
	}
}