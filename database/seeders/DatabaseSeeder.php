<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();
        // $this->call(SQLFileSeeder::class);
        $this->call(UsersTableSeeder::class);
        $this->call(VCRolesTableSeeder::class);
        $this->call(BusinessTypesTableSeeder::class);
        $this->call(RegionsTableSeeder::class);
        $this->call(ProvincesTableSeeder::class);
        $this->call(MunicipalitiesTableSeeder::class);
        //$this->call(RegionsProvincesTableSeeder::class);
        //$this->call(ProvinceMunicipalitiesTableSeeder::class);
        //$this->call(AddressesTableSeeder::class);
        //$this->call(BusinessTableSeeder::class);
        //$this->call(PlayersTableSeeder::class);
        //$this->call(ProductsTableSeeder::class);
        //$this->call(ProductTypesTableSeeder::class);
        //$this->call(PlayerProductsTableSeeder::class);
    }
}
