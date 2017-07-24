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
        DB::table('users')->insert([
            'name' 	=> "David Urs",
            'email' => "david.urs@hpm.ro",
            'password' => bcrypt('parola'),
            'phone' => "026400001",
            "status" => "active"
        ]);


        DB::table('users')->insert([
            'name'  => "me",
            'email' => "d@a",
            'password' => bcrypt('parola'),
            'phone' => "026400001",
            "status" => "active"
        ]);

        
    }
}
