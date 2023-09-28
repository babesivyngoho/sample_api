<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PlayersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $csvFile = fopen(base_path('database\seeders\sample_db\players.csv'), 'r');

        $firstline = true;

        while (($data = fgetcsv($csvFile, 2000, ',')) !== FALSE){
            if (!$firstline) {
                DB::table('players')->insert([
                    //created_at
                    //updated_at
                    'user_id'=> $data['0'],
                    'business_id' => $data['1'],
                    'role_id' => $data['2'],
                    //'description' => $data['6'],
                    //'vc_segment' => $data['7']
                ]);
            }
            $firstline = false;
        }
        fclose($csvFile);
    }
}
