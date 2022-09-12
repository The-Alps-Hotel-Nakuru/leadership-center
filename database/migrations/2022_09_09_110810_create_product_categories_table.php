<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
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
        Schema::create('product_categories', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->longText('description')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });


        DB::table('product_categories')->insert([
            [
                'title' => 'Spices',
            ],
            [
                'title' => 'Sauces',
            ],
            [
                'title' => 'Canned Goods',
            ],
            [
                'title' => 'Snacks',
            ],
            [
                'title' => 'Breads',
            ],
            [
                'title' => 'Paper Goods',
            ],
            [
                'title' => 'Baking Goods',
            ],
            [
                'title' => 'Soups',
            ],
            [
                'title' => 'fruits & vegetables'
            ],
            [
                'title' => 'breakfast foods'
            ],
            [
                'title' => 'pastas & grains'
            ],
            [
                'title' => 'pet food'
            ],
            [
                'title' => 'condiments'
            ],
            [
                'title' => 'vinegars & oils'
            ],
            [
                'title' => 'sides'
            ],
            [
                'title' => 'beans & legumes'
            ],
            [
                'title' => 'nuts & seeds'
            ],
            [
                'title' => 'candies & treats'
            ],
            [
                'title' => 'beverages'
            ],
            [
                'title' => 'jellies & spreads'
            ],
            [
                'title' => 'canned meats'
            ],
            [
                'title' => 'miscellaneous'
            ],
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('product_categories');
    }
};
