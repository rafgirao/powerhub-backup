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
        DB::table('users')->insert([

            'name' => 'Rafael Girão',
            'email' => 'rgiraon@gmail.com',
            'email_verified_at' => '2020-10-31',
            'password' => Hash::make('teste'),
            'country_code' => '55',
            'phone_number' => '85981561600',
            'rememberAccount' => '21417',
            'status' => 1,
        ]);

    }
}
