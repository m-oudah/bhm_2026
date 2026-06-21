<?php

namespace Database\Seeders;

use App\Models\BuildingFinish;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class BuildingFinishSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        BuildingFinish::create(['name' => 'قصارة']);
        BuildingFinish::create(['name' => 'إيطالي']);
        BuildingFinish::create(['name' => 'بلاط']);
        BuildingFinish::create(['name' => 'حجر قدسي']);
        BuildingFinish::create(['name' => 'جرنوليت']);
        BuildingFinish::create(['name' => 'أخرى']);
    }
}
