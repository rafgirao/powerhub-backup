<?php

use Illuminate\Database\Seeder;
use Webpatser\Uuid\Uuid;
use Illuminate\Support\Facades\Crypt;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0');

        DB::table('roles')->truncate();
        DB::table('users')->truncate();
        DB::table('tags')->truncate();
        DB::table('item_tag')->truncate();
        DB::table('categories')->truncate();
        DB::table('items')->truncate();

        DB::statement('SET FOREIGN_KEY_CHECKS=1');

        $this->call([RolesTableSeeder::class, UsersTableSeeder::class]);

        DB::table('accounts')->insert([
            'uuid' => Uuid::generate(),
            'company' => 'Teste 01',
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

//        DB::table('accounts')->insert([
//            'uuid' => Uuid::generate(),
//            'company' => 'Teste 02',
//            'industry' => 'Marketing',
//            'social_name' => 'BigTurn',
//            'document_company' => '1234567890',
//            'leads_balance' => '1000',
//            'operations_balance' => '1000',
//            'users_balance' => '1000',
//            'sms_balance' => '1000',
//            'affiliate' => '1',
//            'country' => 'bra',
//            'country_code' => '55',
//            'zipcode' => '50842230',
//            'street' => 'Rua A',
//            'number' => '123',
//            'complement' => 'Home',
//            'neighborhood' => 'Messejana',
//            'state' => 'CE',
//            'city' => 'Fortaleza',
//            'status' => 1,
//        ]);

//        DB::table('accounts')->insert([
//            'uuid' => Uuid::generate(),
//            'company' => 'Teste 03',
//            'industry' => 'Marketing',
//            'social_name' => 'BigTurn',
//            'document_company' => '1234567890',
//            'leads_balance' => '1000',
//            'operations_balance' => '1000',
//            'users_balance' => '1000',
//            'sms_balance' => '1000',
//            'affiliate' => '1',
//            'country' => 'bra',
//            'country_code' => '55',
//            'zipcode' => '50842230',
//            'street' => 'Rua A',
//            'number' => '123',
//            'complement' => 'Home',
//            'neighborhood' => 'Messejana',
//            'state' => 'CE',
//            'city' => 'Fortaleza',
//            'status' => 1,
//        ]);

        DB::table('integrations')->insert([

            'account' => '21417',
            'provider_name' => 'Active Campaign',
            'provider_type' => 'AutoResponder',
            'description' => 'AC 01',
            'status' => 1,

        ]);

        DB::table('integrations')->insert([

            'account' => 21417,
            'provider_name' => 'Hotmart',
            'provider_type' => 'PaymentGateway',
            'description' => 'Hotmart 01',
            'status' => 1,

        ]);

        DB::table('integrations_det')->insert([

            'account' => 21417,
            'integration' => 1,
            'key' => 'acUrl',
            'value' => Crypt::encryptString('https://bigturntreinamentos.api-us1.com'),

        ]);

        DB::table('integrations_det')->insert([

            'account' => 21417,
            'integration' => 1,
            'key' => 'acToken',
            'value' => Crypt::encryptString('69a92d51c7538556b45a0ac3552701bfe32992d5f8b65b375428a273a8c884f704a76517'),

        ]);


        DB::table('integrations_det')->insert([

            'account' => 21417,
            'integration' => 2,
            'key' => 'clientId',
            'value' => Crypt::encryptString('deabca19-32a9-4e33-957b-b6bafc529b5a'),

        ]);

        DB::table('integrations_det')->insert([

            'account' => 21417,
            'integration' => 2,
            'key' => 'clientSecret',
            'value' => Crypt::encryptString('807652af-2f40-49f2-888f-6c59b6269ade'),

        ]);

        DB::table('integrations_det')->insert([

            'account' => 21417,
            'integration' => 2,
            'key' => 'basic',
            'value' => Crypt::encryptString('Basic ZGVhYmNhMTktMzJhOS00ZTMzLTk1N2ItYjZiYWZjNTI5YjVhOjgwNzY1MmFmLTJmNDAtNDlmMi04ODhmLTZjNTliNjI2OWFkZQ=='),

        ]);

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

        factory(App\User::class)->create([
            'id' => 17367,
            'name' => 'Rafael Girão',
            'email' => 'rgiraon@gmail.com',
            'email_verified_at' => '2020-10-31',
            'role_id' => 1,
            'password' => Hash::make('Ica@204889'),
            'country_code' => '55',
            'phone_number' => '85981561600',
            'status' => 1,
        ]);

        DB::table('user_account')->insert([
            'user' => 17367,
            'account' => 21417,
        ]);

//        DB::table('user_account')->insert([
//            'user' => 17367,
//            'account' => 21418,
//        ]);

//        DB::table('user_account')->insert([
//            'user' => 17367,
//            'account' => 21419,
//        ]);

        DB::table('user_account')->insert([
            'user' => 1,
            'account' => 21417,
        ]);
        DB::table('user_account')->insert([
            'user' => 2,
            'account' => 21417,
        ]);
        DB::table('user_account')->insert([
            'user' => 3,
            'account' => 21417,
        ]);

        DB::table('account_plan')->insert([
            'account' => 21417,
            'plan' => 1,
        ]);

        $this->call([TagsTableSeeder::class, CategoriesTableSeeder::class, ItemsTableSeeder::class]);

//        $this->call(AccountSeeder::class);
//        $this->call([UserAccountSeeder::class]);
//        $this->call(IntegrationSeeder::class);
//        $this->call(PlanSeeder::class);
//        $this->call(AccountTablePlanSeeder::class);

    }
}
