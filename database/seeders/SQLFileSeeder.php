<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SqlFileSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $path = base_path().'/database/seeders/ph-barangay-seed/sappat_db12012022.sql';
        $sql = file_get_contents($path);
        DB::unprepared($sql);
    }

}
