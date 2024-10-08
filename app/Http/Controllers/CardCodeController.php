<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\User;
use App\Models\CardCode;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CardCodeController extends Controller
{

    public function index()
    {
        $searchFields = [
            'influencers.influencer_code',
            'merchants.business_code',
            'card_codes.card_number',
            'merchants.business_name',
            'influencers.blog_name',
        ];

        $tripidkards = User::query()
            ->leftJoin('card_codes', 'card_codes.user_id', '=', 'users.id')
            ->leftJoin('influencers', 'influencers.user_id', '=', 'users.id')
            ->leftJoin('merchants', 'merchants.user_id', '=', 'users.id')
            ->select(
                'card_codes.card_number',
                // Pagsamahin ang business_name o blog_name depende sa kung alin ang meron
                DB::raw('COALESCE(merchants.business_name, influencers.blog_name) as business_or_blog_name')
            )
            ->when(request('query'), function ($query, $searchQuery) use ($searchFields) {
                $query->where(function ($query) use ($searchFields, $searchQuery) {
                    foreach ($searchFields as $field) {
                        $query->orWhere($field, 'like', "%{$searchQuery}%");
                    }
                });
            })
            ->where('card_codes.status', '=', 0)
            ->get();

        return response()->json($tripidkards);
    }


    public function store(Request $request)
    {
        // Validate incoming request data
        $validated = $request->validate([
            'tripidkard_number' => 'required|numeric', // Example validation rule, adjust as needed
            'user_id' => 'required', // Ensure enterprise is selected
            // Add more validation rules as needed
        ]);

        // Retrieve current user
        $user = $request->user();

        // Check if the selected enterprise is "None"



        // Retrieve the number of tripidkards to generate
        $numberOfTripidkards = $request->input('tripidkard_number');
        $user_id = $validated['user_id'];
        // Loop to generate multiple customer codes
        for ($i = 0; $i < $numberOfTripidkards; $i++) {
            $cardNumber = $this->generateCardCode();

            CardCode::create([
                'user_id' => $user_id, // Use enterprise_id or merchant_id as user_id
                'card_number' => $cardNumber,
                'status' => 0,
            ]);
        }

        // Optionally, you can return a response or redirect the user
        return response()->json(['message' => 'Tripidkards generated successfully']);
    }

    public function generateCardCode()
    {
        $currentYear = date('Y');
        $lastCardCode = CardCode::where('card_number', 'like', $currentYear . '-%')->latest('card_number')->value('card_number');
        $lastSerialNumber = 1;
        if ($lastCardCode) {
            $lastSerialNumber = intval(substr($lastCardCode, -7)) + 1;
        }
        return $currentYear . '-0C-' . str_pad($lastSerialNumber, 7, '0', STR_PAD_LEFT);
    }

    public function count()
    {
        $cardCount = CardCode::count();
        return response()->json(['count' => $cardCount]);
    }
}
