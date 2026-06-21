<?php

namespace Database\Seeders;

use App\Models\BuildingPropertyType;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class BuildingPropertyTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        BuildingPropertyType::create(['name' => 'ملك خاص']);
        BuildingPropertyType::create(['name' => 'إيجار']);
        BuildingPropertyType::create(['name' => 'حكومي']);
        BuildingPropertyType::create(['name' => 'بلدية']);
        BuildingPropertyType::create(['name' => 'جمعيات']);
        BuildingPropertyType::create(['name' => 'وقف']);
        BuildingPropertyType::create(['name' => 'وكالة دولية']);
        BuildingPropertyType::create(['name' => 'أخرى']);

    }
}
