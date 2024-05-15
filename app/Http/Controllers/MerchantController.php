<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Merchant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MerchantController extends Controller
{
    public function index()
    {
        $searchFields = [
            'card_code',
            'business_code',
            'business_name',
            'business_category',
            'zip',
            'street',
            'city',
            'province',
            'stars_points',
            'users.fname',
            'users.mname',
            'users.lname',
            'users.contact',
            'users.email'
        ];

        $merchants = Merchant::query()
            ->select('merchants.id AS merchant_id', 'merchants.*', 'users.*')
            ->leftJoin('users', 'merchants.user_id', '=', 'users.id')
            ->when(request('query'), function ($query, $searchQuery) use ($searchFields) {
                $query->where(function ($query) use ($searchFields, $searchQuery) {
                    foreach ($searchFields as $field) {
                        $query->orWhere($field, 'like', "%{$searchQuery}%");
                    }
                });
            })
            ->where('users.status', '!=', '0')
            ->get();

        return response()->json($merchants);
    }



    function generateRandomStringWithNumbers($length)
    {
        $characters = '0123456789';
        $randomString = '';

        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, strlen($characters) - 1)];
        }

        return $randomString;
    }

    function generateBusinessCode($businessName, $length = 8)
    {
        // Remove spaces from the business name
        $businessName = str_replace(' ', '', $businessName);

        // Extract the first few characters from the modified business name (e.g., 3 characters)
        $prefix = substr(strtoupper($businessName), 0, 3);

        // Calculate the length for the unique identifier (to ensure numbers are included)
        $uniqueIdentifierLength = max(0, $length - strlen($prefix));

        // Generate a unique identifier with numbers
        $uniqueIdentifier = $this->generateRandomStringWithNumbers($uniqueIdentifierLength);

        // Combine the prefix and unique identifier to create the store code
        $storeCode = $prefix . $uniqueIdentifier;

        return $storeCode;
    }


    public function generateCardCode()
    {
        $currentYear = date('Y');
        $lastCardCode = Merchant::where('card_code', 'like', $currentYear . '-%')->latest('card_code')->value('card_code');
        $lastSerialNumber = 1;
        if ($lastCardCode) {
            $lastSerialNumber = intval(substr($lastCardCode, -7)) + 1;
        }
        return $currentYear . '-0M-' . str_pad($lastSerialNumber, 7, '0', STR_PAD_LEFT);
    }

    public function store(Request $request)
    {
        // Separate validation for Merchant
        $merchantValidation = $request->validate([
            'business_name' => 'required',
            'business_category' => 'required',
            'business_sub_category' => 'required',
            'zip' => '',
            'street' => '',
            'city' => '',
            'province' => '',
        ]);

        // Start a database transaction
        DB::beginTransaction();

        try {
            // Validate User
            $userValidation = $request->validate([
                'fname' => 'required',
                'lname' => 'required',
                'contact' => 'required',
                'email' => 'required|unique:users,email',
            ]);

            // Generate business code and card code
            $businessCode = $this->generateBusinessCode($merchantValidation['business_name']);
            $cardCode = $this->generateCardCode();

            // Create User
            $user = User::create([
                'fname' => $userValidation['fname'],
                'mname' => request('mname'),
                'lname' => $userValidation['lname'],
                'contact' => $userValidation['contact'],
                'email' => $userValidation['email'],
                'password' => bcrypt($businessCode),
                'role' => 'Merchant',
                'status' => 0,
            ]);

            // Create Merchant
            Merchant::create([
                'user_id' => $user->id,
                'business_code' => $businessCode,
                'card_code' => $cardCode,
                'business_name' => $merchantValidation['business_name'],
                'business_category' => $merchantValidation['business_category'],
                'business_sub_category' => $merchantValidation['business_sub_category'],
                'zip' => request('zip'),
                'street' => request('street'),
                'city' => request('city'),
                'province' => request('province'),
            ]);

            // Commit the transaction
            DB::commit();

            return response()->json(['message' => 'success']);
        } catch (\Exception $e) {
            // Rollback the transaction and delete the user
            DB::rollback();
            if (isset($user)) {
                $user->delete();
            }
            return response()->json(['message' => 'error', 'error' => $e->getMessage()], 500);
        }
    }

    public function edit(Merchant $merchant)
    {
        // Kunin ang merchant kasama ang impormasyon ng user
        $merchantWithUser = Merchant::with('user:id,fname,mname,lname,contact,email')
            ->findOrFail($merchant->id);

        return $merchantWithUser;
    }

    public function update(Request $request, Merchant $merchant)
    {

        $validate = $request->validate([
            'fname' => 'required',
            'lname' => 'required',
            'contact' => 'required',
            'email' => 'required|unique:users,email,' . $merchant->user->id,
            'business_name' => 'required',
            'business_category' => 'required',
            'business_sub_category' => 'required',
            'zip' => 'required',
            'street' => 'required',
            'city' => 'required',
            'province' => 'required',
        ]);

        // Simulan ang transaksyon sa database
        DB::beginTransaction();

        try {
            // Kunin ang user mula sa merchant
            $user = $merchant->user;

            // I-update ang impormasyon ng user
            $user->update([
                'fname' => $validate['fname'],
                'lname' => $validate['lname'],
                'contact' => $validate['contact'],
                'email' => $validate['email'],
            ]);

            // I-update ang impormasyon ng merchant
            $merchant->update([
                'business_name' => $validate['business_name'],
                'business_category' => $validate['business_category'],
                'business_sub_category' => $validate['business_sub_category'],
                'zip' => $validate['zip'],
                'street' => $validate['street'],
                'city' => $validate['city'],
                'province' => $validate['province'],
            ]);

            // Kumpirmahin ang transaksyon at i-commit ito sa database
            DB::commit();

            return response()->json(['message' => 'success']);
        } catch (\Exception $e) {
            // Kung may naganap na error, i-rollback ang transaksyon at itapon ang error
            DB::rollback();
            return response()->json(['message' => 'error', 'error' => $e->getMessage()], 500);
        }
    }



}

