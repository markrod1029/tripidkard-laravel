<?php

namespace Database\Seeders;

use App\Models\Location;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class LocationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        $csvFilePath = base_path('storage/data/locations.csv');
        $file = fopen($csvFilePath,'r');

        // Read Header one line but not include
        $header = fgetcsv($file);

        while (($data = fgetcsv($file)) !== false):
            Location::create([
                'province' => $data[0],
                'description'=> $data[1],
            ]);
        endwhile;

    }
}
