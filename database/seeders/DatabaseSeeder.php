<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Database\Seeders\MerchantSeeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {

        $this->call([
            UserSeeder::class,
            MerchantSeeder::class,
            CardCodeSeeder::class,
            CustomerSeeder::class,
            StarSeeder::class,
            LocationSeeder::class,
            InfluencerSeeder::class,
        ]);
    }
}
