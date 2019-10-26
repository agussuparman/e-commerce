<?php

use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        App\User::create([
        	'name' => 'Admin',
        	'email' => 'admin@gmail.com',
        	'password' => bcrypt('secret'),
        	'role' => 'admin'
        ]);

        App\User::create([
        	'name' => 'Customer',
        	'email' => 'customer@gmail.com',
        	'password' => bcrypt('secret'),
        	'role' => 'customer'
        ]);
    }
}
