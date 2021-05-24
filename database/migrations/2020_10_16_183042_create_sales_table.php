<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSalesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sales', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('account');

            $table->unsignedBigInteger('lead');
            $table->unsignedBigInteger('product');
            $table->string('transaction')->unique()->nullable();

            $table->decimal('commission',10,2)->nullable();
            $table->string('commission_currency')->nullable();
            $table->decimal('price',10,2)->nullable();
            $table->string('price_currency')->nullable();

            $table->string('payment_type')->nullable();
            $table->string('payment_method')->nullable();
            $table->string('payment_mode')->nullable();

            $table->integer('recurrence_number')->nullable();
            $table->integer('warranty_refund')->nullable();
            $table->integer('installments_number')->nullable();

            $table->string('affiliate')->nullable();
            $table->string('payment_engine')->nullable();
            $table->string('sales_nature')->nullable();
            $table->string('coupon_code')->nullable();
            $table->string('offer')->nullable();
            $table->string('status')->nullable();

            $table->dateTime('purchase_date')->nullable();
            $table->dateTime('confirmation_date')->nullable();
            $table->timestamps();

            $table->foreign('account')->references('id')->on('accounts')->onDelete('CASCADE');
            $table->foreign('lead')->references('id')->on('leads')->onDelete('CASCADE');
            $table->foreign('product')->references('id')->on('products')->onDelete('CASCADE');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('sales');
    }
}
