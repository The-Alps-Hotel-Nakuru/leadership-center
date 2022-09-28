<?php

namespace Database\Seeders;

use App\Models\AssetCategory;
use App\Models\AssetSubcategory;
use Faker\Factory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AssetCategoriesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Factory::create();


        for ($i=0; $i < 16; $i++) {
            $cat =  new AssetCategory();

            $cat->title = $faker->title;
            $cat->description = $faker->realText;
            $cat->created_by = 1;
            $cat->save();
        }

        for ($i=0; $i < 50; $i++) {
            $sub = new AssetSubcategory();
            $sub->title = $faker->jobTitle;
            $sub->asset_category_id = rand(1, count(AssetCategory::all()));
            $sub->created_by = 1;
            $sub->save();

        }


    }
}
