<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnsToProjectsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('projects', function (Blueprint $table) {
            $table->string('niche')->nullable()->default(null)->after('status');
            $table->string('sub_niche')->nullable()->default(null)->after('niche');
            $table->string('type')->nullable()->default(null)->after('sub_niche');
            $table->string('instagram')->nullable()->default(null)->after('type');
            $table->string('facebook')->nullable()->default(null)->after('instagram');
            $table->string('youtube')->nullable()->default(null)->after('facebook');
            $table->string('avatar')->nullable()->default(null)->after('youtube');
            $table->string('transformation')->nullable()->default(null)->after('avatar');
            $table->text('strengths')->nullable()->default(null)->after('transformation');
            $table->text('weaknesses')->nullable()->default(null)->after('strengths');
            $table->text('opportunities')->nullable()->default(null)->after('weaknesses');
            $table->text('threats')->nullable()->default(null)->after('opportunities');
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
                'niche',
                'sub_niche',
                'type',
                'instagram',
                'facebook',
                'youtube',
                'avatar',
                'transformation',
                'strengths',
                'weaknesses',
                'opportunities',
                'threats',
            ]);
        });
    }
}
