<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTagsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tags', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('account');
            $table->unsignedBigInteger('integration');
            $table->unsignedBigInteger('provider_tag_id');
            $table->string('name');
            $table->string('color', 7)->nullable()->default(null);
            $table->string('tag_type')->nullable();
            $table->string('description')->nullable();
            $table->string('subscriber_count')->nullable();
            $table->timestamps();

            $table->unique(['account', 'integration', 'provider_tag_id']);
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
        Schema::dropIfExists('tags');
    }
}
