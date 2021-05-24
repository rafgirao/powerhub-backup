<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEmailCampaignsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('email_campaigns', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('account');
            $table->unsignedBigInteger('integration');
            $table->bigInteger('provider_email_campaign_id');
            $table->string('campaign_name')->nullable();
            $table->string('campaign_subject')->nullable();
            $table->dateTime('last_sent_date')->nullable();
            $table->bigInteger('sends')->nullable();
            $table->bigInteger('opens')->nullable();
            $table->bigInteger('unique_opens')->nullable();
            $table->bigInteger('clicks')->nullable();
            $table->bigInteger('unique_clicks')->nullable();
            $table->bigInteger('forwards')->nullable();
            $table->bigInteger('unique_forwards')->nullable();
            $table->bigInteger('unsubscribes')->nullable();
            $table->bigInteger('bounces')->nullable();
//            $table->float('open_rate')->nullable();
//            $table->float('click_to_open_rate')->nullable();
//            $table->float('click_rate')->nullable();
//            $table->float('forward_rate')->nullable();
//            $table->float('unsubscribe_rate')->nullable();
//            $table->float('bounce_rate')->nullable();
            $table->string('screenshot')->nullable();
            $table->boolean('status')->default(1);
            $table->timestamps();

            $table->unique(['account', 'integration', 'provider_email_campaign_id'], 'aipecid');
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
        Schema::dropIfExists('email_campaigns');
    }
}
