<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SampleData extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //

        $this->call(ProductSeeder::class);
        $this->call(FoodOptions::class);
        $this->call(ProductType::class);
        $this->call(StoreSeeder::class);
    }
}
