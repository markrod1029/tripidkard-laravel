<?php

namespace Database\Seeders;

use App\Models\CardCode;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CardCodeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $csvFilePath = base_path('storage/data/card-codes.csv');
        $file = fopen($csvFilePath,'r');

        // Read Header one line but not include
        $header = fgetcsv($file);

        while (($data = fgetcsv($file)) !== false):
            CardCode::create([
                'user_id' => $data[0],
                'card_number'=> $data[1],
                'status'=> $data[2],
                'validity'=> $data[3],
            ]);
        endwhile;
    }
}
