<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCampaignsInsightsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('campaigns_insights', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('account');
            $table->unsignedBigInteger('campaign');
            $table->unsignedBigInteger('insight');
            $table->string('group')->nullable();
            $table->decimal('value',10,2)->nullable();
            $table->date(
                'date')->nullable();
            $table->timestamps();

            $table->foreign('account')->references('id')->on('accounts')->onDelete('CASCADE');
            $table->foreign('campaign')->references('id')->on('campaigns')->onDelete('CASCADE');
            $table->foreign('insight')->references('id')->on('insights')->onDelete('CASCADE');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('campaigns_insights');
    }
}
