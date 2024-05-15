<?php

namespace Database\Seeders;

use App\Models\Merchant;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class MerchantSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        $csvFilePath = base_path('storage/data/merchants.csv');
        $file = fopen($csvFilePath, 'r');

        // read the header one line but not include
        $header = fgetcsv($file);

        while(($data = fgetcsv($file)) !== false):
            Merchant::create([
                'user_id' => $data[0],
                'business_code' => $data[1],
                'card_code' => $data[2],
                'business_name' => $data[3],
                'business_category' => $data[4],
                'business_sub_category' => $data[5],
                'zip' => $data[6],
                'street' => $data[7],
                'city' => $data[8],
                'province' => $data[9]
            ]);

        endwhile;

    }
}
