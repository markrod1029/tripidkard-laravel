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
                "user_id"=> $data[1],
                "fname"=> $data[2],
                "mname"=> $data[3],
                "lname"=> $data[4],
                "contact"=> $data[5],
                "bdate"=> $data[6],
                "email"=> $data[7],
                "zip"=> $data[8],
                "street"=> $data[9],
                "city"=> $data[10],
                "province"=> $data[11],
                "status"=> $data[12],
            ]);

        endwhile;
    }
}
