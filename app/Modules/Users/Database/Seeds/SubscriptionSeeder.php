<?php
namespace App\Modules\Users\Database\Seeds;

use CodeIgniter\Database\Seeder;

class SubscriptionSeeder extends Seeder
{
	public function run()
	{
		$faker = \Faker\Factory::create();

		$data = [];

		for ($i = 0; $i < 1000; $i++) {
			$data[] = [
				'email' => $faker->unique()->safeEmail,
				'name'  => $faker->name,
				'phone' => $faker->phoneNumber,
				'token' => bin2hex(random_bytes(16)), // creates a random token
				'created_at' => $faker->numberBetween($min = 1682256990, $max = 1692256990),
			];
		}

		// Using Query Builder
		$this->db->table('subscriptions')->insertBatch($data);
	}
}