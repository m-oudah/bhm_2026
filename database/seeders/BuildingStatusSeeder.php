<?php

namespace Database\Seeders;

use App\Models\BuildingStatus;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class BuildingStatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        BuildingStatus::create(['name' => 'مهدوم']);
        BuildingStatus::create(['name' => 'تحت الإنشاء']);
        BuildingStatus::create(['name' => 'أرض فضاء']);
        BuildingStatus::create(['name' => 'أخرى']);

    }
}
