<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePlansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('plans', function (Blueprint $table) {

            $table->id();
            $table->string('name');
            $table->string('description')->nullable();
            $table->string('subscription_type');
            $table->string('user_country');
            $table->string('currency');
            $table->decimal('amount', 10,2);
            $table->integer('leads')->nullable();
            $table->integer('operations')->nullable();
            $table->integer('subusers')->nullable();
            $table->integer('sms')->nullable();
            $table->boolean('status')->default(1);
            $table->timestamps();

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('plans');
    }
}
