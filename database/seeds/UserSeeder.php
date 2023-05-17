<?php

use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $users = [
            [  'first_name' => 'dummy',
                'last_name' => 'admin',
                'email' => 'team.alkurn@gmail.com',
                'password' => Hash::make('Alk@456#urn'),
                'user_type' => 'admin',
                'email_verified_at' => date("Y-m-d h:i:s"),
                'created_at' => date("Y-m-d h:i:s")],
            [  'first_name' => 'vallaki',
                'last_name' => 'dudhiya',
                'email' => 'vallaki.alkurn@gmail.com',
                'password' => Hash::make('123456789'),
                'user_type' => 'customer',
                'email_verified_at' => date("Y-m-d h:i:s"),
                'created_at' => date("Y-m-d h:i:s")]

        ];
        DB::table('users')->insert($users);

    }
}
