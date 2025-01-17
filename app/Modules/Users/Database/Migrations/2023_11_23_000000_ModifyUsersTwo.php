<?php namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class ModifyUsersTwo extends Migration
{
	public function up()
	{
		$this->db->disableForeignKeyChecks();

		// Add new column after password
		$this->forge->addColumn('users',[
			'start_turnover' => [
				'type' => 'FLOAT',
				'constraint' => '10,2',
				'null' => false,
				'default' => '0',
				'before' => 'turnover',
				'after' => 'password',
			],
		]);

		$this->db->enableForeignKeyChecks();
	}

	public function down()
	{
		$this->db->disableForeignKeyChecks();

		// Drop the new column
		$this->forge->dropColumn('users', 'start_turnover');

		$this->db->enableForeignKeyChecks();
	}
}