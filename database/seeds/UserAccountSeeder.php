<?php

use Illuminate\Database\Seeder;

class UserAccountSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('user_account')->insert([

            'user' => '17367',
            'account' => '21417',
        ]);
    }
}
