<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductTypesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //$csvFile = fopen(base_path('database\seeders\db\product_types.csv'), 'r');

        $firstline = true;

        //while (($data = fgetcsv($csvFile, 2000, ',')) !== FALSE){
            //if (!$firstline) {
                DB::table('product_types')->insert([
                    ['name'=> "Raw Material"],
                    ['name'=> "Technology/Equipment"],
                    ['name'=> "Service"]
                ]);
                //'created_at'
                //'updated_at'
            //}
            //$firstline = false;
        //}
        //fclose($csvFile);
    }
}
