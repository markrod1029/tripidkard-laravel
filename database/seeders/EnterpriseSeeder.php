<?php

namespace Database\Seeders;

use App\Models\Enterprise;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class EnterpriseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        
        $csvFilePath = base_path('storage/data/enterprises.csv');
        $file = fopen($csvFilePath, 'r');

        // read the header one line but not include
        $header = fgetcsv($file);

        while(($data = fgetcsv($file)) !== false):
            Enterprise::create([
                'user_id' => $data[0],
                'business_code' => $data[1],
                'card_code' => $data[2],
                'business_name' => $data[3],
                'business_category' => $data[4],
                'zip' => $data[5],
                'street' => $data[6],
                'city' => $data[7],
                'province' => $data[8]
            ]);
        
        endwhile;
    }
}
