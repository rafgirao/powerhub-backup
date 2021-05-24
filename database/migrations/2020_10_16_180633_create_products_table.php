<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('account');
            $table->unsignedBigInteger('integration')->nullable();
            $table->bigInteger('gateway_product_id')->nullable();
            $table->string('product_name')->nullable();
            $table->string('seller_id')->nullable();
            $table->string('seller_name')->nullable();
            $table->string('payment_mode')->nullable();
            $table->string('cover_photo')->nullable();
            $table->boolean('coproduction')->nullable();
            $table->boolean('approved')->nullable();
            $table->boolean('revised')->nullable();
            $table->boolean('enabled')->nullable();
            $table->boolean('deleted')->nullable();
            $table->boolean('pixel')->nullable();
            $table->boolean('smart_installment')->nullable();
            $table->decimal('price', 10, 2)->nullable();
            $table->string('price_currency')->nullable();
            $table->string('payment_engine')->nullable();
            $table->string('status')->nullable();
            $table->string('gateway_creation_date')->nullable();
            $table->timestamps();

            $table->foreign('account')->references('id')->on('accounts')->onDelete('CASCADE');
            $table->foreign('integration')->references('id')->on('integrations')->onDelete('CASCADE');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('products');
    }
}
