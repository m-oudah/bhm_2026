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
        Schema::create('attachments', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('license_form_id')->nullable();
            $table->string('url')->nullable();
            $table->string('category')->nullable();



            // $table->string('title_deed')->nullable();//سندات الملكية
            // $table->string('general_site_plan')->nullable();//مخطط الموقع العام
            // $table->string('construction_map')->nullable();//خرائط البناء
            // $table->string('undertaking_supervise')->nullable();//تعهد بالإشراف
            // $table->string('aprobaciones_terceros')->nullable();//مصادقات جهات أخرى
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
        Schema::dropIfExists('license_form_attachments');
    }
};
