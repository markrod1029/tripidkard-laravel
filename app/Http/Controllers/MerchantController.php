<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Merchant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MerchantController extends Controller
{
    public function index() {
        $searchFields = [
            'card_code', 'business_code', 'business_name', 'business_category',
            'zip', 'street', 'city', 'province', 'users.fname', 'users.mname',
            'users.lname', 'users.contact', 'users.email'
        ];
    
        $merchants = Merchant::query()
            ->leftJoin('users', 'merchants.user_id', '=', 'users.id')
            ->when(request('query'), function ($query, $searchQuery) use ($searchFields) {
                $query->where(function ($query) use ($searchFields, $searchQuery) {
                    foreach ($searchFields as $field) {
                        $query->orWhere($field, 'like', "%{$searchQuery}%");
                    }
                });
            })
            ->get();
        
        return response()->json($merchants);
    }
    
    
    

    public function store(Request $request) {

        // dd($request->all());
    
        $validate = $request->validate([
            'fname' => 'required', 
            'lname' => 'required',
            'contact' => 'required',
            'email' => 'required|unique:users,email',
            'business_name' => 'required',
            'business_category' => 'required',
            'business_sub_category' => 'required',
            'zip' => 'required',
            'street' => 'required',
            'city' => 'required',
            'province' => 'required',
        ]);
    
        $user =  User::create([
            'fname' => $validate['fname'],  // Dapat ito ay 'mname' base sa iyong design
            'mname' => request('mname'),     // Dapat ito ay 'fname' base sa iyong design
            'lname' => $validate['lname'],
            'contact' => $validate['contact'],
            'email' => $validate['email'],
            'password' => bcrypt($validate['email']), // Hindi ito isang magandang ideya. Gumamit ka ng unique field para sa password
            'role' => 'Merchant',
            'status' => 1,
        ]);
    
        Merchant::create([
            'user_id' =>  $user->id, 
            'business_name' => $validate['business_name'], // Dapat ito ay $validate['business_name']
            'business_category' => $validate['business_category'], // Dapat ito ay $validate['business_category']
            'business_sub_category' => $validate['business_sub_category'], // Dapat ito ay $validate['business_sub_category']
            'zip' => $validate['zip'],
            'street' => $validate['street'],
            'city' => $validate['city'],
            'province' => $validate['province'],
        ]);
    
        return response()->json(['message' => 'success']);
    
    }

    public function edit(Merchant $merchant) {
        // Kunin ang merchant kasama ang impormasyon ng user
        $merchantWithUser = Merchant::with('user:id,fname,mname,lname,contact,email')
            ->findOrFail($merchant->id);
        
        return $merchantWithUser;
    }

    public function update(Request $request, Merchant $merchant){

        $validate = $request->validate([
            'fname' => 'required', 
            'lname' => 'required',
            'contact' => 'required',
            'email' => 'required|unique:users,email,'.$merchant->user->id,
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

