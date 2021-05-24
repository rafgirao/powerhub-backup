<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateItemTagTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('item_tag', function (Blueprint $table) {

            $table->id();
            $table->unsignedBigInteger('account');
            $table->unsignedBigInteger('item_id');
            $table->unsignedBigInteger('tag_id');

            $table->foreign('account')->references('id')->on('accounts')->onDelete('CASCADE');
            $table->foreign('item_id')->references('id')->on('items')->onDelete('CASCADE');
            $table->foreign('tag_id')->references('id')->on('tags')->onDelete('CASCADE');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('item_tag');
    }
}
