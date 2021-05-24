<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFieldsToProjectsDetTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('projects_det', function (Blueprint $table) {
            $table->dropColumn('kpi');
            $table->nullableMorphs('kpi');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('projects_det', function (Blueprint $table) {
            $table->dropColumn('kpi_type');
            $table->dropColumn('kpi_id');
            $table->string('kpi')->after('key_id')->nullable();
        });
    }
}
