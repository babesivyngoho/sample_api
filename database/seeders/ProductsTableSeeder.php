<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $csvFile = fopen(base_path('database\seeders\sample_db\products.csv'), 'r');

        $firstline = true;

        while (($data = fgetcsv($csvFile, 2000, ',')) !== FALSE){
            if (!$firstline) {
                //if (DB::table('products')->where('name', $data['3'])->doesntExist()){
                    DB::table('products')->insert([
                        'name'=> $data['0'],
                        'description' => $data['1'],
                        //'product_type_id' => 1
                        //'created_at'
                        //'updated_at'
                    ]);
                //}
            }
            $firstline = false;
        }
        fclose($csvFile);
    }
}
