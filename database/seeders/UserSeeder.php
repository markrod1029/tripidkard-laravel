<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $csvFilePath = base_path('storage/data/users.csv');
        $file = fopen($csvFilePath, 'r');

        // read the header one line but not include
        $header = fgetcsv($file);

        while(($data = fgetcsv($file)) !== false):
            USER::create([
                'fname' => $data[0],
                'mname' => $data[1],
                'lname' => $data[2],
                'contact' => $data[3],
                'email' => $data[4],
                'password' => $data[5],
                'role' => $data[6],
                'status' => $data[7],
            ]);

        endwhile;

    }
}
