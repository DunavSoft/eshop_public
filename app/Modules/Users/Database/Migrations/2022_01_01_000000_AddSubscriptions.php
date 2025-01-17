<?php namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddSubscription extends Migration
{
	public function up()
	{
		$this->forge->addField([
			'id' => [
				'type' => 'INT',
				'constraint' => 10,
				'unsigned' => true,
				'auto_increment' => true,
			],
			'email' => [
				'type' => 'VARCHAR',
				'constraint' => 128,
				'default' => ''
			],
			'article_id' => [
				'type' => 'INT',
				'constraint' => 10,
				'unsigned' => true,
			],
			'campaign_id' => [
				'type' => 'INT',
				'constraint' => 10,
				'unsigned' => true,
			],
			'token' => [
				'type' => 'VARCHAR',
				'constraint' => 32,
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
		$this->forge->addKey('article_id');
		$this->forge->addKey('campaign_id');

		$attributes = ['ENGINE' => 'InnoDB'];

		$this->forge->addForeignKey('article_id', 'articles', 'id', 'CASCADE', 'CASCADE');
		$this->forge->addForeignKey('campaign_id', 'products', 'id', 'CASCADE', 'CASCADE');

		$this->forge->createTable('subscriptions', false, $attributes);

		$this->db->enableForeignKeyChecks();
	}

	public function down()
	{
		$this->db->disableForeignKeyChecks();

		$this->forge->dropTable('subscriptions');

		$this->db->enableForeignKeyChecks();
	}
}
