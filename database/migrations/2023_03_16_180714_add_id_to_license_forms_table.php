<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('license_forms', function (Blueprint $table) {
            $table->bigInteger('title_deed_id')->nullable();
            $table->bigInteger('general_site_plan_id')->nullable();
            $table->bigInteger('construction_map_id')->nullable();
            $table->bigInteger('undertaking_supervise_id')->nullable();
            $table->bigInteger('aprobaciones_terceros_id')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('license_forms', function (Blueprint $table) {
            //
        });
    }
};
