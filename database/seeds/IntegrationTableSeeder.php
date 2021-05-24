<?php

use Illuminate\Database\Seeder;

class IntegrationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('integrations')->insert([

            'account' => '21417',
            'provider_name' => 'ActiveCampaign',
            'provider_type' => 'AutoResponder',
            'description' => 'AC 01',
            'status' => 1,

        ]);

        DB::table('integrations')->insert([

            'account' => '21417',
            'provider_name' => 'Hotmart',
            'provider_type' => 'PaymentGateway',
            'description' => 'Hotmart 01',
            'status' => 1,

        ]);

        DB::table('integrations_det')->insert([

            'integration' => 1,
            'key' => 'acToken',
            'value' => '7e7e624e8e3900a363a968544a9049a6f1ef9a072d282e81153fa51c3a381ae885e84c87',

        ]);

        DB::table('integrations_det')->insert([

            'integration' => 1,
            'key' => 'acUrl',
            'value' => 'https://camilafarani7.api-us1.com',

        ]);

        DB::table('integrations_det')->insert([

            'integration' => 2,
            'key' => 'clientId',
            'value' => 'deabca19-32a9-4e33-957b-b6bafc529b5a',

        ]);

        DB::table('integrations_det')->insert([

            'integration' => 2,
            'key' => 'clientSecret',
            'value' => '807652af-2f40-49f2-888f-6c59b6269ade',

        ]);

        DB::table('integrations_det')->insert([

            'integration' => 2,
            'key' => 'basic',
            'value' => 'Basic ZGVhYmNhMTktMzJhOS00ZTMzLTk1N2ItYjZiYWZjNTI5YjVhOjgwNzY1MmFmLTJmNDAtNDlmMi04ODhmLTZjNTliNjI2OWFkZQ==',

        ]);
    }
}
