<?php

use Illuminate\Database\Seeder;

class AccountTablePlanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('account_plan')->insert([
            'account' => 21417,
            'plan' => 1,
        ]);
    }
}
