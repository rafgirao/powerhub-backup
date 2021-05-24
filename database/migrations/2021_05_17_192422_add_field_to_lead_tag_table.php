<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFieldToLeadTagTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('lead_tag', function (Blueprint $table) {
            $table->timestamp('provider_created_at')->nullable()->after('tag');
            $table->timestamp('provider_updated_at')->nullable()->after('provider_created_at');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('lead_tag', function (Blueprint $table) {
            $table->dropColumn('provider_created_at');
            $table->dropColumn('provider_updated_at');
        });
    }
}
