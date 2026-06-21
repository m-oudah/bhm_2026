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
        Schema::create('license_forms', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('building_id')->nullable();
            $table->string('first_name')->nullable();
            $table->string('second_name')->nullable();
            $table->string('third_name')->nullable();
            $table->string('sur_name')->nullable();
            $table->string('id_card')->nullable();
            $table->string('block_number')->nullable();
            $table->string('parcel_number')->nullable();
            $table->string('legal_opinion')->nullable();
            $table->string('area_opinion')->nullable();
            $table->string('plan_opinion')->nullable();
            $table->string('water_opinion')->nullable();
            $table->string('sewer_opinion')->nullable();
            $table->string('collection_opinion')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('license_forms');
    }
};
