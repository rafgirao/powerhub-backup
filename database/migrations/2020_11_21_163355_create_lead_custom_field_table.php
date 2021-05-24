<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLeadCustomFieldTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('lead_custom_field', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('account');
            $table->unsignedBigInteger('lead');
            $table->unsignedBigInteger('custom_field');
            $table->timestamps();

            $table->foreign('account')->references('id')->on('accounts')->onDelete('CASCADE');
            $table->foreign('lead')->references('id')->on('leads')->onDelete('CASCADE');
            $table->foreign('custom_field')->references('id')->on('custom_fields')->onDelete('CASCADE');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('lead_custom_field');
    }
}
