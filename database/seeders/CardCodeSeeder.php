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
                'card_types' => $data[1],
                'card_number'=> $data[2],
                'status'=> $data[3],
                'validity'=> $data[4],
            ]);
        endwhile;
    }
}
