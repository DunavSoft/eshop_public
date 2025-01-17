<?php namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class ModifyUsers extends Migration
{
	public function up()
	{
		$this->db->disableForeignKeyChecks();

		// Add new column after password
		$this->forge->addColumn('users',[
			'turnover' => [
				'type' => 'FLOAT',
				'constraint' => '10,2',
				'null' => false,
				'default' => '0',
				'before' => 'active',
				'after' => 'password',
			],
		]);

		$this->db->enableForeignKeyChecks();
	}

	public function down()
	{
		$this->db->disableForeignKeyChecks();

		// Drop the new column
		$this->forge->dropColumn('users', 'turnover');

		$this->db->enableForeignKeyChecks();
	}
}