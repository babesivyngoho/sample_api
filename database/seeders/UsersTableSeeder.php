<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Nette\Utils\DateTime;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $csvFile = fopen(base_path('database\seeders\sample_db\users.csv'), 'r');

        $firstline = true;

        while (($data = fgetcsv($csvFile, 2000, ',')) !== FALSE){
            if (!$firstline) {
                for($i = 0; $i < sizeof($data); $i++){
                    if(is_null($data[$i]) || empty($data[$i]) || $data[$i] == 'NULL'){
                        $data[$i] = NULL;
                    }
                }

                DB::table('users')->insert([
                    'name'=> $data['0'],
                    'assigned_sex_at_birth' => $data['1'],
                    'email' => $data['2'],
                    'contact_no' => $data['3'],
                    //'email_verified_at' => date('Y-m-d H:i:s', $data['3']),
                    'password' => Hash::make($data['2']),
                    'active' => (int) $data['4']
                    //'remember_token' => $data['7'],
                    //'profile_photo_path' => $data['9'],
                    //'created_at' => $newDate,
                    //'updated_at' => date_format($data['11'], "Y-m-d H:i:s"),
                    //'active' => (int) $data['12']
                ]);
            }
            $firstline = false;
        }
        fclose($csvFile);
    }
}
