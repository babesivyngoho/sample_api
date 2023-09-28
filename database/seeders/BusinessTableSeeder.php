<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BusinessTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $csvFile = fopen(base_path('database\seeders\sample_db\business.csv'), 'r');

        $firstline = true;

        while (($data = fgetcsv($csvFile, 2000, ',')) !== FALSE){
            if (!$firstline) {
                for($i = 0; $i < sizeof($data); $i++){
                    if(is_null($data[$i]) || empty($data[$i]) || $data[$i] == 'NULL'){
                        $data[$i] = NULL;
                    }
                }

                DB::table('business')->insert([
                    'name'=> $data['0'],
                    'business_address' => $data['1'],
                    'business_type' => $data['2'],
                ]);
            }
            $firstline = false;
        }
        fclose($csvFile);
    }
}
