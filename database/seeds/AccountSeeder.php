<?php

use Illuminate\Database\Seeder;

class AccountSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('accounts')->insert([
            'company' => 'BigTurn',
            'industry' => 'Marketing',
            'social_name' => 'BigTurn',
            'document_company' => '1234567890',
            'leads_balance' => '1000',
            'operations_balance' => '1000',
            'users_balance' => '1000',
            'sms_balance' => '1000',
            'affiliate' => '1',
            'country' => 'bra',
            'country_code' => '55',
            'zipcode' => '50842230',
            'street' => 'Rua A',
            'number' => '123',
            'complement' => 'Home',
            'neighborhood' => 'Messejana',
            'state' => 'CE',
            'city' => 'Fortaleza',
            'status' => 1,
        ]);
    }
}
