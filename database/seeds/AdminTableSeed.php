<?php
use Illuminate\Database\Seeder;

class AdminTableSeed extends Seeder
{
	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		DB::table('admins')->insert([
			'admin_name' => 'admin',
			'password'   => bcrypt('11223344'),
		]);
	}
}
