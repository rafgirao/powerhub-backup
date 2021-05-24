<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddMoreFieldsToProjectsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('projects', function (Blueprint $table) {
            $table->decimal('revenue_goal_min', 10,2)->nullable()->default(null)->after('leads_goal');
            $table->decimal('revenue_goal_max', 10,2)->nullable()->default(null)->after('revenue_goal');
            $table->integer('whatsapp_goal')->nullable()->default(null)->after('leads_goal');
            $table->integer('telegram_goal')->nullable()->default(null)->after('whatsapp_goal');
            $table->date('cart_at')->nullable()->default(null)->after('end_at');
            $table->text('comments')->nullable()->default(null)->after('cart_at');
            $table->text('cp_timeline')->nullable()->default(null)->after('status');
            $table->text('cp_opportunities')->nullable()->default(null)->after('cp_timeline');
            $table->text('cp_avatar_pains_dreams')->nullable()->default(null)->after('cp_opportunities');
            $table->text('cp_copy')->nullable()->default(null)->after('cp_avatar_pains_dreams');
            $table->text('cp_event_name')->nullable()->default(null)->after('cp_copy');
            $table->text('cp_event_promises')->nullable()->default(null)->after('cp_event_name');
            $table->text('cp_avatar_objections')->nullable()->default(null)->after('cp_event_promises');
            $table->text('cp_avatar_traps_myths')->nullable()->default(null)->after('cp_avatar_objections');
            $table->text('cp_design_launch_line')->nullable()->default(null)->after('cp_avatar_traps_myths');
            $table->text('cp_product_qualities')->nullable()->default(null)->after('cp_design_launch_line');
            $table->text('cp_product_efficiency')->nullable()->default(null)->after('cp_product_qualities');
            $table->text('cp_product_unique')->nullable()->default(null)->after('cp_product_efficiency');
            $table->text('cp_product_steps')->nullable()->default(null)->after('cp_product_unique');
            $table->text('cp_product_warranty')->nullable()->default(null)->after('cp_product_steps');
            $table->text('cp_offer_unique')->nullable()->default(null)->after('cp_product_warranty');
            $table->text('cp_common_enemy')->nullable()->default(null)->after('cp_offer_unique');
            $table->text('cp_who')->nullable()->default(null)->after('cp_common_enemy');
            $table->text('cp_requirements')->nullable()->default(null)->after('cp_who');
            $table->decimal('cp_niche', 10,2)->nullable()->default(null)->after('cp_who');
            $table->decimal('cp_product', 10,2)->nullable()->default(null)->after('cp_niche');
            $table->decimal('cp_offer', 10,2)->nullable()->default(null)->after('cp_product');
            $table->text('cp_strategy')->nullable()->default(null)->after('cp_offer');
            $table->text('cp_aggregates')->nullable()->default(null)->after('cp_strategy');
            $table->text('cp_offers_description')->nullable()->default(null)->after('cp_aggregates');
            $table->text('cp_structure')->nullable()->default(null)->after('cp_offers_description');
            $table->text('cp_links')->nullable()->default(null)->after('cp_structure');
            $table->text('cp_definitions')->nullable()->default(null)->after('cp_links');
            $table->text('cp_ads_copy')->nullable()->default(null)->after('cp_definitions');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('projects', function (Blueprint $table) {
             $table->dropColumn([
                     'revenue_goal_min',
                     'revenue_goal_max',
                     'whatsapp_groups',
                     'cart_at',
                     'comments',
                     'cp_timeline',
                     'cp_opportunities',
                     'cp_avatar_pains_dreams',
                     'cp_copy',
                     'cp_event_name',
                     'cp_event_promises',
                     'cp_avatar_objections',
                     'cp_avatar_traps_myths',
                     'cp_design_launch_line',
                     'cp_product_qualities',
                     'cp_product_efficiency',
                     'cp_product_unique',
                     'cp_product_steps',
                     'cp_product_warranty',
                     'cp_offer_unique',
                     'cp_common_enemy',
                     'cp_who',
                     'cp_requirements',
                     'cp_niche',
                     'cp_product',
                     'cp_offer',
                     'cp_strategy',
                     'cp_aggregates',
                     'cp_offers_description',
                     'cp_structure',
                     'cp_links',
                     'cp_definitions',
                     'cp_ads_copy',
             ]);
        });
    }
}
