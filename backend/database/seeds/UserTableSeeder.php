<?php

use Illuminate\Database\Seeder;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'name' => 'admin',
            'last_name' => 'admin',
            'email' => 'admin@example.com',
            'password' => bcrypt('secret'),
            'is_admin' => true,
            'status' => 1,
        ]);
    }
}
