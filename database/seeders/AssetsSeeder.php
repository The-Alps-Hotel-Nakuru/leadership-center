<?php

namespace Database\Seeders;

use App\Models\Asset;
use App\Models\AssetCategory;
use App\Models\AssetItem;
use App\Models\AssetSubcategory;
use App\Models\Department;
use Carbon\Carbon;
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
        for ($i = 0; $i < 500; $i++) {
            $asset = new Asset();
            $asset->asset_category_id = rand(1, count(AssetCategory::all()));
            $asset->asset_subcategory_id = rand(1, count(AssetSubcategory::all()));
            $asset->department_id = rand(1, count(Department::all()));
            $asset->title = $faker->word;
            $asset->description = $faker->text;
            $asset->unit_cost_kes = $faker->randomFloat(2, 0.5, 250) * 100;
            $asset->created_by = 1;
            $asset->save();

            $no = random_int(7, 15);

            for ($j = 0; $j < $no; $j++) {
                $item = new AssetItem();
                $item->asset_id = $asset->id;
                $item->sku_number = 'AC' . $asset->asset_category_id . 'AS' . $asset->id . 'ASI' . $j;
                $item->purchase_date = Carbon::now()->toDateString();
                $item->cost_kes = $asset->unit_cost_kes + $faker->randomFloat(2, 0.5, 250) * 10;
                $item->save();
            }
        }
    }
}
