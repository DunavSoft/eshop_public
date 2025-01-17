<?php namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class ModifySubscription extends Migration
{
	public function up()
	{
		$this->db->disableForeignKeyChecks();
		
		// Drop the foreign keys related to article_id and campaign_id
		$this->forge->dropForeignKey('subscriptions', 'subscriptions_article_id_foreign');
		$this->forge->dropForeignKey('subscriptions', 'subscriptions_campaign_id_foreign');

		// Drop fields article_id and campaign_id
		$this->forge->dropColumn('subscriptions', 'article_id');
		$this->forge->dropColumn('subscriptions', 'campaign_id');

		// Add new fields after email
		$this->forge->addColumn('subscriptions', [
			'name' => [
				'type' => 'VARCHAR',
				'constraint' => 255,
				'null' => true,
				'default' => null,
				'after' => 'email',
			],
			'phone' => [
				'type' => 'VARCHAR',
				'constraint' => 40,
				'null' => true,
				'default' => null,
				'after' => 'name',
			],
		]);
		
		$this->db->enableForeignKeyChecks();
	}

	public function down()
	{
		$this->db->disableForeignKeyChecks();
		
		// Re-add the article_id and campaign_id columns
		$this->forge->addColumn('subscriptions', [
			'article_id' => [
				'type' => 'INT',
				'constraint' => 10,
				'unsigned' => true,
				'after' => 'email'
			],
			'campaign_id' => [
				'type' => 'INT',
				'constraint' => 10,
				'unsigned' => true,
				'after' => 'article_id'
			],
		]);

		// Add the foreign keys back
		$this->forge->addForeignKey('article_id', 'articles', 'id', 'CASCADE', 'CASCADE');
		$this->forge->addForeignKey('campaign_id', 'products', 'id', 'CASCADE', 'CASCADE');

		// Drop the new fields
		$this->forge->dropColumn('subscriptions', 'name');
		$this->forge->dropColumn('subscriptions', 'phone');
		
		$this->db->enableForeignKeyChecks();
	}
}
