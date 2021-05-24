<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProjectsDetTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('projects_det', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('account');
            $table->unsignedBigInteger('project');
            $table->morphs('key');
            $table->string('kpi')->nullable();
            $table->decimal('target',10,2)->nullable();
            $table->timestamps();

            $table->foreign('account')->references('id')->on('accounts')->onDelete('CASCADE');
            $table->foreign('project')->references('id')->on('projects')->onDelete('CASCADE');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('projects_det');
    }
}
