<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCampaignsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('campaigns', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('account');
            $table->unsignedBigInteger('integration_det')->nullable();
            $table->bigInteger('provider_campaign_id')->nullable();
            $table->string('provider_campaign_name')->nullable();
            $table->string('buying_type')->nullable();
            $table->string('objective')->nullable();
            $table->string('status')->nullable();
            $table->string('bid_strategy')->nullable();
            $table->float('daily_budget')->nullable();
            $table->float('lifetime_budget')->nullable();
            $table->dateTime('start_time')->nullable();
            $table->dateTime('stop_time')->nullable();
            $table->timestamps();

            $table->foreign('account')->references('id')->on('accounts')->onDelete('CASCADE');
            $table->foreign('integration_det')->references('id')->on('integrations_det')->onDelete('CASCADE');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('campaigns');
    }
}
