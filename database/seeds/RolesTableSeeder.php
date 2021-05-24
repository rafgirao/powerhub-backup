<?php

use Illuminate\Database\Seeder;

class RolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('roles')->insert([
            'id' => 1,
            'name' => 'Admin',
            'description' => 'This is the administration role',
            'guard_name' => '',
            'created_at' => now(),
            'updated_at' => now()
        ]);

        DB::table('roles')->insert([
            'id' => 2,
            'name' => 'Support',
            'description' => 'This is the Support role',
            'guard_name' => '',
            'created_at' => now(),
            'updated_at' => now()
        ]);

        DB::table('roles')->insert([
            'id' => 3,
            'name' => 'User',
            'description' => 'This is the member role',
            'guard_name' => '',
            'created_at' => now(),
            'updated_at' => now()
        ]);
    }
}
