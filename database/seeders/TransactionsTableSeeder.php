<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TransactionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $csvFile = fopen(base_path('database\seeders\db\transactions.csv'), 'r');

        $firstline = true;

        while (($data = fgetcsv($csvFile, 2000, ',')) !== FALSE){
            if (!$firstline) {
                DB::table('player_products')->insert([
                    'player_id'=> $data['1'],
                    'supplier_id' => $data['2'],
                    'product_id' => $data['3'],
                    'mode_of_aquisition' => $data['4'],
                    //'date_acquired' => $data['5'],
                    'quantity' => $data['6'],
                    'status' => $data['7']
                ]);
            }
            $firstline = false;
        }
        fclose($csvFile);
    }
}
