<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('items', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('account');
            $table->string('name');
            $table->text('description')->nullable();
            $table->string('picture')->nullable();
            $table->unsignedBigInteger('category_id');
            $table->timestamps();

            $table->unique(['account', 'name']);
            $table->foreign('account')->references('id')->on('accounts')->onDelete('CASCADE');
            $table->foreign('category_id')->references('id')->on('categories');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('items');
    }
}
