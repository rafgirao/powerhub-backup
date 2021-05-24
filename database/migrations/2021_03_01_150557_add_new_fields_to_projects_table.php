<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddNewFieldsToProjectsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('projects', function (Blueprint $table) {
            $table->bigInteger('instagram_followers_before')->nullable()->default(null)->after('instagram');
            $table->bigInteger('instagram_followers_after')->nullable()->default(null)->after('instagram_followers_before');
            $table->bigInteger('facebook_fans_before')->nullable()->default(null)->after('facebook');
            $table->bigInteger('facebook_fans_after')->nullable()->default(null)->after('facebook_fans_before');
            $table->bigInteger('youtube_subscribers_before')->nullable()->default(null)->after('youtube');
            $table->bigInteger('youtube_subscribers_after')->nullable()->default(null)->after('youtube_subscribers_before');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('projects', function (Blueprint $table) {
            $table->dropColumn([
                'instagram_followers_before',
                'instagram_followers_after',
                'facebook_fans_before',
                'facebook_fans_after',
                'youtube_subscribers_before',
                'youtube_subscribers_after'
            ]);
        });
    }
}
