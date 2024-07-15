<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductSeasonTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $product_id = 1;
        $season_ids = [3, 4];

        foreach ($season_ids as $season_id) {
            DB::table('product_season')->insert([
                'product_id' => $product_id,
                'season_id' => $season_id,
            ]);
        }

        $product_id = 2;
        $season_ids = [1];

        foreach ($season_ids as $season_id) {
            DB::table('product_season')->insert([
                'product_id' => $product_id,
                'season_id' => $season_id,
            ]);
        }

        $product_id = 3;
        $season_ids = [4];

        foreach ($season_ids as $season_id) {
            DB::table('product_season')->insert([
                'product_id' => $product_id,
                'season_id' => $season_id,
            ]);
        }

        $product_id = 4;
        $season_ids = [2];

        foreach ($season_ids as $season_id) {
            DB::table('product_season')->insert([
                'product_id' => $product_id,
                'season_id' => $season_id,
            ]);
        }

        $product_id = 5;
        $season_ids = [2];

        foreach ($season_ids as $season_id) {
            DB::table('product_season')->insert([
                'product_id' => $product_id,
                'season_id' => $season_id,
            ]);
        }

        $product_id = 6;
        $season_ids = [2, 3];

        foreach ($season_ids as $season_id) {
            DB::table('product_season')->insert([
                'product_id' => $product_id,
                'season_id' => $season_id,
            ]);
        }

        $product_id = 7;
        $season_ids = [1, 2];

        foreach ($season_ids as $season_id) {
            DB::table('product_season')->insert([
                'product_id' => $product_id,
                'season_id' => $season_id,
            ]);
        }

        $product_id = 8;
        $season_ids = [2, 3];

        foreach ($season_ids as $season_id) {
            DB::table('product_season')->insert([
                'product_id' => $product_id,
                'season_id' => $season_id,
            ]);
        }

        $product_id = 9;
        $season_ids = [2];

        foreach ($season_ids as $season_id) {
            DB::table('product_season')->insert([
                'product_id' => $product_id,
                'season_id' => $season_id,
            ]);
        }

        $product_id = 10;
        $season_ids = [1, 2];

        foreach ($season_ids as $season_id) {
            DB::table('product_season')->insert([
                'product_id' => $product_id,
                'season_id' => $season_id,
            ]);
        }
    }
}
