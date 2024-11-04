<?php

namespace App\Jobs;

use App\Models\CardCode;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class GenerateCardCodes implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $userId;
    protected $cardTypes;
    protected $numberOfTripidkards;

    /**
     * Create a new job instance.
     */
    public function __construct($userId, $cardTypes, $numberOfTripidkards)
    {
        $this->userId = $userId;
        $this->cardTypes = $cardTypes;
        $this->numberOfTripidkards = $numberOfTripidkards;
    }

    /**
     * Execute the job.
     */
    public function handle()
    {
        $cardCodes = [];
        for ($i = 0; $i < $this->numberOfTripidkards; $i++) {
            $cardCodes[] = [
                'user_id' => $this->userId,
                'card_number' => $this->generateCardCode(),
                'card_types' => $this->cardTypes,
                'status' => 0,
                'created_at' => now(),
                'updated_at' => now(),
            ];

            // Insert in chunks of 500 (adjust as needed based on server resources)
            if (count($cardCodes) === 500) {
                CardCode::insert($cardCodes);
                $cardCodes = [];
            }
        }

        // Insert remaining card codes
        if (!empty($cardCodes)) {
            CardCode::insert($cardCodes);
        }
    }

    private function generateCardCode()
    {
        // Your card number generation logic here
        return rand(1000000000, 9999999999); // Example
    }
}

