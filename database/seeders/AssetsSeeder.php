<?php

namespace Database\Seeders;

use App\Models\Asset;
use App\Models\AssetCategory;
use App\Models\AssetSubcategory;
use App\Models\Department;
use Faker\Factory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AssetsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Factory::create();
        for ($i=0; $i < 500; $i++) {
            $asset = new Asset();
            $asset->asset_category_id = rand(1, count(AssetCategory::all()));
            $asset->asset_subcategory_id = rand(1, count(AssetSubcategory::all()));
            $asset->department_id = rand(1, count(Department::all()));
            $asset->title = $faker->word;
            $asset->description = $faker->text;
            $asset->quantity = 0;
            $asset->unit_cost_kes = $faker->randomFloat(2, 0.5, 250) * 100;
            $asset->created_by = 1;
            $asset->save();

        }
    }
}
