<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RegionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $csvFile = fopen(base_path('database\seeders\sample_db\regions.csv'), 'r');

        $firstline = true;

        while (($data = fgetcsv($csvFile, 2000, ',')) !== FALSE){
            if (!$firstline) {
                DB::table('regions')->insert([
                    //created_at
                    //updated_at
                    'name'=> $data['0'],
                    //'description' => $data['6'],
                    //'vc_segment' => $data['7']
                ]);
            }
            $firstline = false;
        }
        fclose($csvFile);
    }
}
