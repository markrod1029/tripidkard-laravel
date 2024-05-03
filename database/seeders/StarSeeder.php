<?php

namespace Database\Seeders;

use App\Models\Star;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class StarSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $csvFilePath = base_path('storage/data/stars.csv');
        $file = fopen($csvFilePath, 'r');

        // read the header one line but not include
        $header = fgetcsv($file);

        while(($data = fgetcsv($file)) !== false):
            Star::create([
                'stars' => $data[0],
            ]);

        endwhile;

    }
}
