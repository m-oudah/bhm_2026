<?php

namespace Database\Seeders;

use App\Models\BuildingUse;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class BuildingUseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        BuildingUse::create(['name' => 'سكني']);
        BuildingUse::create(['name' => 'تجاري']);
        BuildingUse::create(['name' => 'صناعي']);
        BuildingUse::create(['name' => 'تعليمي']);
        BuildingUse::create(['name' => 'ثقافي']);
        BuildingUse::create(['name' => 'صحي']);
        BuildingUse::create(['name' => 'سياحي']);
        BuildingUse::create(['name' => 'ديني']);
        BuildingUse::create(['name' => 'مؤسسات']);
        BuildingUse::create(['name' => 'مهجور']);
        BuildingUse::create(['name' => 'حالة خاصة']);
        BuildingUse::create(['name' => 'أخرى']);
    }
}
