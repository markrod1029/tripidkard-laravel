<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Enterprise;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class EnterpriseController extends Controller
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
            'users.fname',
            'users.mname',
            'users.lname',
            'users.contact',
            'users.email'
        ];

        $enterprises = Enterprise::query()
            ->leftJoin('users', 'enterprises.user_id', '=', 'users.id')
            ->when(request('query'), function ($query, $searchQuery) use ($searchFields) {
                $query->where(function ($query) use ($searchFields, $searchQuery) {
                    foreach ($searchFields as $field) {
                        $query->orWhere($field, 'like', "%{$searchQuery}%");
                    }
                });
            })
            ->get();

        return response()->json($enterprises);

    }

    public function store(Request $request)
    {

        // dd($request->all());

        $validate = $request->validate([
            'fname' => 'required',
            'lname' => 'required',
            'contact' => 'required',
            'email' => 'required|unique:users,email',
            'business_name' => 'required',
            'business_category' => 'required',
            'zip' => 'required',
            'street' => 'required',
            'city' => 'required',
            'province' => 'required',
        ]);

        $user = User::create([
            'fname' => $validate['fname'],  
            'mname' => request('mname'),   
            'lname' => $validate['lname'],
            'contact' => $validate['contact'],
            'email' => $validate['email'],
            'password' => bcrypt($validate['email']), 
            'role' => 'Merchant',
            'status' => 1,
        ]);

        Enterprise::create([
            'user_id' => $user->id,
            'business_name' => $validate['business_name'], 
            'zip' => $validate['zip'],
            'street' => $validate['street'],
            'city' => $validate['city'],
            'province' => $validate['province'],
        ]);

        return response()->json(['message' => 'success']);

    }

    public function edit(Enterprise $enterprise) {
          // get a Enterprise include of information of user
          $enterpriseWithUser = Enterprise::with('user:id,fname,mname,lname,contact,email')
          ->findOrFail($enterprise->id);
      
      return $enterpriseWithUser;

      dd($enterpriseWithUser);
    }

    public function update(Request $request, Enterprise $enterprise){

        $validate = $request->validate([
            'fname' => 'required', 
            'lname' => 'required',
            'contact' => 'required',
            'email' => 'required|unique:users,email,'.$enterprise->user->id,
            'business_name' => 'required',
            'business_category' => 'required',
            'zip' => 'required',
            'street' => 'required',
            'city' => 'required',
            'province' => 'required',
        ]);
    
        // Simulan ang transaksyon sa database
        DB::beginTransaction();
    
        try {
            // Kunin ang user mula sa merchant
            $user = $enterprise->user;
    
            // I-update ang impormasyon ng user
            $user->update([
                'fname' => $validate['fname'],
                'lname' => $validate['lname'],
                'contact' => $validate['contact'],
                'email' => $validate['email'],
            ]);
    
            // I-update ang impormasyon ng merchant
            $enterprise->update([
                'business_name' => $validate['business_name'],
                'business_category' => $validate['business_category'],
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
