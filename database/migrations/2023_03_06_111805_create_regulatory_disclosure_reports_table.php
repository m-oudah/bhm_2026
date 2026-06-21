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
        Schema::create('regulatory_disclosure_reports', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('building_id');
            $table->tinyInteger('isproperty')->nullable();//حالة التملك
            $table->tinyInteger('isorted')->nullable();//حالة الفرز
            $table->tinyInteger('region')->nullable();//حالة المنطقة
            $table->tinyInteger('location_status')->nullable();//حالة الموقع
            $table->string('total_coupon_space')->nullable();//مساحة القسيمة الإجمالية//////
            $table->string('building_area')->nullable();//مساحة البناء
            $table->string('rebounds_front')->nullable();//الارتدادات
            $table->string('rebounds_back')->nullable();
            $table->string('rebounds_right')->nullable();
            $table->string('rebounds_left')->nullable();
            $table->string('construction_ratio')->nullable();//نسبة البناء
            $table->string('number_floor')->nullable();//عدد الطوابق
            $table->text('purpose_building_use')->nullable();//هدف استعمال البناء
            $table->text('site_on_structural')->nullable();//الموقع على شارع أو شوارع هيكلية أو تفصيلية أو تنظيمية
            $table->text('passes_through_site')->nullable();//يمر بالموقع شارع أو شوارع هيكيلية أو تفصيلية أو مساحية
            $table->text('territory_regulatory_requirement')->nullable();//الشروط التنظيمية للمنطقة
            $table->text('department_notes')->nullable();//ملاحظات دائرة التنظيم
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
        Schema::dropIfExists('regulatory_disclosure_reports');
    }
};
