<?php

use Illuminate\Database\Seeder;

class TagsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        DB::table('tags')->insert([
            'id' => 1,
            'account' => 21417,
            'name' => 'Hot',
            'color' => '#f5365c',
            'integration' => '2',
            'provider_tag_id' => '1',
            'created_at' => now(),
            'updated_at' => now()
        ]);

        DB::table('tags')->insert([
            'id' => 2,
            'account' => 21417,
            'name' => 'Trending',
            'color' => '#5e72e4',
            'integration' => '2',
            'provider_tag_id' => '2',
            'created_at' => now(),
            'updated_at' => now()
        ]);

        DB::table('tags')->insert([
            'id' => 3,
            'account' => 21417,
            'name' => 'New',
            'color' => '#11cdef',
            'integration' => '2',
            'provider_tag_id' => '3',
            'created_at' => now(),
            'updated_at' => now()
        ]);

    }
}
