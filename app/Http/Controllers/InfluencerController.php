<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Influencer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class InfluencerController extends Controller
{

    public function index()
    {
        $searchFields = [
            'card_code',
            'Influencer_code',
            'blog_name',
            'blog_category',
            'zip',
            'street',
            'city',
            'province',
            'users.fname',
            'users.mname',
            'users.lname',
            'users.contact',
            'users.email'
        ];

        $influencers = Influencer::query()
            ->select('influencers.id AS influencer_id', 'users.id AS user_id', 'influencers.*', 'users.*')
            ->leftJoin('users', 'influencers.user_id', '=', 'users.id')
            ->when(request('query'), function ($query, $searchQuery) use ($searchFields) {
                $query->where(function ($query) use ($searchFields, $searchQuery) {
                    foreach ($searchFields as $field) {
                        $query->orWhere($field, 'like', "%{$searchQuery}%");
                    }
                });
            })
            ->where('users.status', '=', '1')
            ->get();

        return response()->json($influencers);
    }

    public function indexPending()
    {
        $searchFields = [
            'card_code',
            'Influencer_code',
            'blog_name',
            'blog_category',
            'zip',
            'street',
            'city',
            'province',
            'users.fname',
            'users.mname',
            'users.lname',
            'users.contact',
            'users.email'
        ];

        $influencers = Influencer::query()
            ->select('influencers.id AS influencer_id', 'influencers.*', 'users.*')
            ->leftJoin('users', 'influencers.user_id', '=', 'users.id')
            ->when(request('query'), function ($query, $searchQuery) use ($searchFields) {
                $query->where(function ($query) use ($searchFields, $searchQuery) {
                    foreach ($searchFields as $field) {
                        $query->orWhere($field, 'like', "%{$searchQuery}%");
                    }
                });
            })
            ->where('users.status', '=', '0')
            ->get();

        return response()->json($influencers);
    }


    public function indexArchive()
    {
        $searchFields = [
            'card_code',
            'Influencer_code',
            'blog_name',
            'blog_category',
            'zip',
            'street',
            'city',
            'province',
            'users.fname',
            'users.mname',
            'users.lname',
            'users.contact',
            'users.email'
        ];

        $influencers = Influencer::query()
            ->select('influencers.id AS influencer_id', 'influencers.*', 'users.*')
            ->leftJoin('users', 'influencers.user_id', '=', 'users.id')
            ->when(request('query'), function ($query, $searchQuery) use ($searchFields) {
                $query->where(function ($query) use ($searchFields, $searchQuery) {
                    foreach ($searchFields as $field) {
                        $query->orWhere($field, 'like', "%{$searchQuery}%");
                    }
                });
            })
            ->where('users.status', '=', '5')
            ->get();

        return response()->json($influencers);
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
        $lastCardCode = Influencer::where('card_code', 'like', $currentYear . '-%')->latest('card_code')->value('card_code');
        $lastSerialNumber = 1;
        if ($lastCardCode) {
            $lastSerialNumber = intval(substr($lastCardCode, -7)) + 1;
        }
        return $currentYear . '-0I-' . str_pad($lastSerialNumber, 7, '0', STR_PAD_LEFT);
    }

    public function store(Request $request)
    {
        // Separate validation for Influencer
        $influencerValidation = $request->validate([
            'blog_name' => 'required',
            'blog_category' => 'required',
            'zip' => '',
            'street' => 'required',
            'city' => 'required',
            'province' => 'required',
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
            $businessCode = $this->generateBusinessCode($influencerValidation['blog_name']);
            $cardCode = $this->generateCardCode();

            // Create User
            $user = User::create([
                'fname' => $userValidation['fname'],
                'mname' => request('mname'),
                'lname' => $userValidation['lname'],
                'contact' => $userValidation['contact'],
                'email' => $userValidation['email'],
                'password' => bcrypt($businessCode),
                'role' => 'Influencer',
                'status' => 0,
            ]);


            // Create Influencer
            Influencer::create([
                'user_id' => $user->id,
                'influencer_code' => $businessCode,
                'card_code' => $cardCode,
                'blog_name' => $influencerValidation['blog_name'],
                'blog_category' => $influencerValidation['blog_category'],
                'zip' => request('zip'),
                'street' => request('street'),
                'city' => request('city'),
                'province' => request('province'),
            ]);

            // Commit the transaction
            DB::commit();

            $user = Auth::user();
            activity()
                ->performedOn($user)
                ->causedBy($user)
                ->withProperties(['role' => $user->role, 'status' => $user->status])
                ->log('Added Influencer');

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

    public function edit(Influencer $influencer)
    {

        // Kunin ang Influencer kasama ang impormasyon ng user
        $influencerWithUser = Influencer::with('user:id,fname,mname,lname,contact,email')
            ->findOrFail($influencer->id);

        return $influencerWithUser;
    }

    public function update(Request $request, Influencer $influencer)
    {

        $validate = $request->validate([
            'fname' => 'required',
            'lname' => 'required',
            'contact' => 'required',
            'email' => 'required|unique:users,email,' . $influencer->user->id,
            'blog_name' => 'required',
            'blog_category' => 'required',
            'zip' => 'required',
            'street' => 'required',
            'city' => 'required',
            'province' => 'required',
        ]);

        // Simulan ang transaksyon sa database
        DB::beginTransaction();

        try {
            // Kunin ang user mula sa Influencer
            $user = $influencer->user;

            // I-update ang impormasyon ng user
            $user->update([
                'fname' => $validate['fname'],
                'lname' => $validate['lname'],
                'contact' => $validate['contact'],
                'email' => $validate['email'],
            ]);

            // I-update ang impormasyon ng influencer
            $influencer->update([
                'blog_name' => $validate['blog_name'],
                'blog_category' => $validate['blog_category'],
                'zip' => $validate['zip'],
                'street' => $validate['street'],
                'city' => $validate['city'],
                'province' => $validate['province'],
            ]);

            // Kumpirmahin ang transaksyon at i-commit ito sa database
            DB::commit();


            $user = Auth::user();
            activity()
                ->performedOn($user)
                ->causedBy($user)
                ->withProperties(['role' => $user->role, 'status' => $user->status])
                ->log('Updated Influencer');
            return response()->json(['message' => 'success']);
        } catch (\Exception $e) {
            // Kung may naganap na error, i-rollback ang transaksyon at itapon ang error
            DB::rollback();
            return response()->json(['message' => 'error', 'error' => $e->getMessage()], 500);
        }
    }
    public function approve(Request $request, $id)
    {
        $user = User::findOrFail($id);
        $status = $request->input('status');
        $user->update(['status' => $status]);
        return response()->json(['message' => 'Influencer status updated successfully.']);
    }

    public function archive(Request $request, $id)
    {
        $user = User::findOrFail($id);
        $status = $request->input('status');
        $user->update(['status' => $status]);
        return response()->json(['message' => 'Influencer status updated successfully.']);
    }


    public function count()
    {
        $influencerCount = User::where('role', 'Influencer')
            ->where('status', 1)->count();
        return response()->json(['count' => $influencerCount]);
    }



}
