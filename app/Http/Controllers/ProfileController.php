<?php

namespace App\Http\Controllers;

use App\Models\Enterprise;
use App\Models\Merchant;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
    public function index(Request $request) {
        $user = request()->user();
         $profileDetails = $user->only(['id', 'fname', 'mname', 'lname', 'contact', 'email', 'role', 'avatar']);

         if($user->role === 'Merchant') {

            $merchant = Merchant::where('user_id', $user->id)->first();

            $profileDetails['business_name'] = $merchant->business_name;
            $profileDetails['business_category'] = $merchant->business_category;
            $profileDetails['business_sub_category'] = $merchant->business_sub_category;
            $profileDetails['zip'] = $merchant->zip;
            $profileDetails['street'] = $merchant->street;
            $profileDetails['city'] = $merchant->city;
            $profileDetails['province'] = $merchant->province;


        } else if( $user->role === 'Enterprise') {

            $enterprise = Enterprise::where('user_id', $user->id)->first();

            $profileDetails['business_name'] = $enterprise->business_name;
            $profileDetails['business_category'] = $enterprise->business_category;
            $profileDetails['zip'] = $enterprise->zip;
            $profileDetails['city'] = $enterprise->city;
            $profileDetails['province'] = $enterprise->province;

        }

        return $profileDetails;
    }
}
