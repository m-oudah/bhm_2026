<?php

namespace Database\Seeders;

use App\Models\BuildingMaterial;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class BuildingMaterialSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        BuildingMaterial::create(['name' => 'باطون']);
        BuildingMaterial::create(['name' => 'أسبست']);
        BuildingMaterial::create(['name' => 'قرميد']);
        BuildingMaterial::create(['name' => ' صفيح/زينكو']);
        BuildingMaterial::create(['name' => 'أخرى']);

    }
}
