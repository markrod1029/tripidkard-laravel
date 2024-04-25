<?php

namespace Database\Seeders;

use App\Models\Customer;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class CustomerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $csvFilePath = base_path("storage/data/customers.csv");
        $file = fopen($csvFilePath,"r");

        // Read Header one line but not include
        $header = fgetcsv($file);

        while ($data = fgetcsv($file)):
            Customer::create([
                "customer_card_num"=> $data[0],
                "fname"=> $data[1],
                "mname"=> $data[2],
                "lname"=> $data[3],
                "contact"=> $data[4],
                "bdate"=> $data[5],
                "email"=> $data[6],
                "zip"=> $data[7],
                "street"=> $data[8],
                "city"=> $data[9],
                "province"=> $data[10],
                "status"=> $data[11],
            ]);

        endwhile;
    }
}
