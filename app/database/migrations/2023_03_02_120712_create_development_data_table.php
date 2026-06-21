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
        Schema::create('development_data', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('floor_description_id');
            $table->string('dev_price_per_meter')->nullable();
            $table->string('discount')->nullable();
            $table->string('pay_fees')->nullable();
            $table->string('totle_fees')->nullable();
            $table->string('discount_val')->nullable();
            $table->string('required_pay')->nullable();
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
        Schema::dropIfExists('development_data');
    }
};
