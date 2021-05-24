<?php

use Illuminate\Database\Seeder;

class PlanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('plans')->insert([

            'name' => 'Free',
            'description' => 'Free',
            'subscription_type' => 'recurrency',
            'user_country' => 'BRA',
            'currency' => 'BRL',
            'amount' => '0',
            'leads' => '1000',
            'operations' => '100',
            'subusers' => '0',
            'sms' => '100',
            'status' => '1'
        ]);
    }
}
