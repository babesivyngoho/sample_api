<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PlayerProductsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $csvFile = fopen(base_path('database\seeders\sample_db\player_products.csv'), 'r');

        $firstline = true;

        while (($data = fgetcsv($csvFile, 2000, ',')) !== FALSE){
            /*$product = DB::table('products')
                ->select('id')
                ->where('name', $data[3])
                ->pluck('id');
            */
            if (!$firstline) {
                DB::table('player_products')->insert([
                    'business_name'=> $data['0'],
                    'sector' => $data['1'],
                    'location' => $data['2'],
                    'vc_player_type' => $data['3'],
                    'products' => $data['4'],
                ]);
            }
            $firstline = false;
        }
        fclose($csvFile);
    }
}