<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateWebhookCallsTable extends Migration
{
    public function up()
    {
        Schema::create('webhook_calls', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('account');

            $table->string('name');
            $table->text('payload')->nullable();
            $table->text('exception')->nullable();

            $table->timestamps();

            $table->foreign('account')->references('id')->on('accounts')->onDelete('CASCADE');
        });
    }

    public function down()
    {
        Schema::dropIfExists('webhook_calls');
    }
}
