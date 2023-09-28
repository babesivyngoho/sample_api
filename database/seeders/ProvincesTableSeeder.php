<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProvincesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $csvFile = fopen(base_path('database\seeders\sample_db\provinces.csv'), 'r');

        $firstline = true;

        while (($data = fgetcsv($csvFile, 2000, ',')) !== FALSE){
            if (!$firstline) {
                DB::table('provinces')->insert([
                    //created_at
                    //updated_at
                    'name'=> $data['0'],
                    'region_id' => $data['1'],
                    //'description' => $data['6'],
                    //'vc_segment' => $data['7']
                ]);
            }
            $firstline = false;
        }
        fclose($csvFile);
    }
}