<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAccountsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('accounts', function (Blueprint $table) {
            $table->id();
            /** account */
            $table->uuid('uuid');
            $table->string('company')->nullable();
            $table->string('industry')->nullable();
            $table->string('social_name')->nullable();
            $table->string('document_company')->nullable();
            $table->string('timezone')->nullable();
            $table->string('key')->nullable();
            $table->string('affiliate')->nullable();

            /** balance */
            $table->integer('leads_balance')->nullable();
            $table->integer('operations_balance')->nullable();
            $table->integer('users_balance')->nullable();
            $table->integer('sms_balance')->nullable();

            /** address */
            $table->string('country_code')->nullable();
            $table->string('country')->nullable();
            $table->string('zipcode')->nullable();
            $table->string('street')->nullable();
            $table->string('number')->nullable();
            $table->string('complement')->nullable();
            $table->string('neighborhood')->nullable();
            $table->string('state')->nullable();
            $table->string('city')->nullable();

            $table->boolean('status')->default(1);
            $table->timestamps();
        });
        $prefix = DB::getTablePrefix();
        DB::update("ALTER TABLE ".$prefix."accounts AUTO_INCREMENT = 21417;");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('accounts');
    }
}
