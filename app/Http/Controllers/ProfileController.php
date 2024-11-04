<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Merchant;
use App\Models\Enterprise;
use App\Models\Influencer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Exceptions\InvalidPasswordException;
use App\Actions\Account\UpdateUserPasswordAction;

class ProfileController extends Controller
{
    public function index(Request $request)
    {
        $user = request()->user();
        $profileDetails = $user->only(['id','fname', 'mname', 'lname', 'contact', 'email', 'role', 'avatar', 'photo1', 'photo2', 'photo3']);

        if ($user->role === 'Merchant') {

            $merchant = Merchant::where('user_id', $user->id)->first();

            $profileDetails['user_id'] = $merchant->user_id;
            $profileDetails['business_code'] = $merchant->business_code;
            $profileDetails['card_code'] = $merchant->card_code;
            $profileDetails['business_name'] = $merchant->business_name;
            $profileDetails['business_category'] = $merchant->business_category;
            $profileDetails['discount'] = $merchant->discount;
            $profileDetails['stars_points'] = $merchant->stars_points;
            $profileDetails['business_sub_category'] = $merchant->business_sub_category;
            $profileDetails['zip'] = $merchant->zip;
            $profileDetails['street'] = $merchant->street;
            $profileDetails['city'] = $merchant->city;
            $profileDetails['province'] = $merchant->province;
            $profileDetails['description'] = $merchant->description;
            $profileDetails['tagline'] = $merchant->tagline;


        } else if ($user->role === 'Influencer') {

            $influencer = Influencer::where('user_id', $user->id)->first();
            $profileDetails['influencer_code'] = $influencer->influencer_code;
            $profileDetails['card_code'] = $influencer->card_code;
            $profileDetails['blog_name'] = $influencer->blog_name;
            $profileDetails['blog_category'] = $influencer->business_category;
            $profileDetails['zip'] = $influencer->zip;
            $profileDetails['city'] = $influencer->city;
            $profileDetails['province'] = $influencer->province;

        }

        return $profileDetails;
    }

    public function updateProfile(Request $request)
    {

        $user = $request->user();

        $validate = $request->validate([
            'fname' => 'required',
            'mname' => '',
            'lname' => 'required',
            'email' => 'required|unique:users,email,' . $user->id,
            'contact' => 'required|unique:users,contact,' . $user->id,
        ]);

        // Kumuha ng mga validated data
        $validatedData = $request->only(['fname', 'mname', 'lname', 'email', 'contact']);

        // I-update ang impormasyon ng user
        $user->update($validatedData);


        $user = Auth::user();
        // Get the authenticated user
        $user = Auth::user();
        $name = $user->role === 'Merchant'
        ? $user->business_name
        : ($user->role === 'Influencer'
            ? $user->blog_name
            : trim($user->fname . ' ' . $user->mname . ' ' . $user->lname));

        activity()
            ->performedOn($user)
            ->causedBy($user)
        ->withProperties(['role' => $user->role, 'status' => $user->status])
        ->log("$name updated their profile.");

        return response()->json(['message' => 'User information updated successfully'], 200);
    }

    public function updateBusiness(Request $request)
    {
        // Kunin ang tamang rekord ng negosyo mula sa query na may left join
        $business = Merchant::leftJoin('users', 'users.id', '=', 'merchants.user_id')
            ->where('users.id', $request->user()->id)
            ->select('merchants.*')
            ->first();
        // Kumpirmahin kung mayroong negosyo na nauugnay sa user
        if (!$business) {
            return response()->json(['message' => 'User does not have associated business'], 404);
        }

        if ($request->access === 'description') {

            // Dito iproseso ang pag-update ng deskripsyon ng negosyo
            $validate = $request->validate([
                'discount' => 'required',
                'description' => 'required',
                'tagline' => 'required',
            ]);
            $validatedData = $request->only(['discount', 'description', 'tagline']);
            // I-update ang impormasyon ng negosyo
            $business->update($validatedData);
            return response()->json(['message' => 'Business Description updated successfully'], 200);
        } else {

            // Dito iproseso ang pag-update ng iba pang impormasyon ng negosyo (e.g., information)
            $validate = $request->validate([
                'business_name' => 'required',
                'business_category' => 'required',
                'business_sub_category' => 'required',
                'zip' => 'required',
                'street' => 'required',
                'city' => 'required',
                'province' => 'required',
            ]);
            $validatedData = $request->only(['business_name', 'business_category', 'business_sub_category', 'zip', 'street', 'city', 'province']);

            // I-update ang impormasyon ng negosyo
            $business->update($validatedData);
            $user = Auth::user();
            // Get the authenticated user
            $user = Auth::user();
            $name = $user->role === 'Merchant'
            ? $user->business_name
            : ($user->role === 'Influencer'
                ? $user->blog_name
                : trim($user->fname . ' ' . $user->mname . ' ' . $user->lname));

            activity()
                ->performedOn($user)
                ->causedBy($user)
            ->withProperties(['role' => $user->role, 'status' => $user->status])
            ->log("$name updated their business information.");

            return response()->json(['message' => 'Business information updated successfully'], 200);
        }
    }


    public function uploadImage(Request $request)
    {
        // Ensure the file is present in the request
        if ($request->hasFile('profile_picture')) {
            // Get the current avatar path
            $previousPath = $request->user()->getRawOriginal('avatar');

            // Define the path for the new image
            $path = 'photos/logo';

            // Ensure the directory exists
            if (!Storage::disk('public')->exists($path)) {
                Storage::disk('public')->makeDirectory($path);
            }

            // Store the new image
            $link = Storage::disk('public')->put($path, $request->file('profile_picture'));

            // Update the user's avatar in the database
            $request->user()->update(['avatar' => $link]);

            // Delete the previous image if it exists
            if ($previousPath) {
                Storage::disk('public')->delete($previousPath);
            }

            return response()->json(['message' => 'Profile Picture Uploaded Successfully']);
        }

        $user = Auth::user();
        // Get the authenticated user
        $user = Auth::user();
        $name = $user->role === 'Merchant'
        ? $user->business_name
        : ($user->role === 'Influencer'
            ? $user->blog_name
            : trim($user->fname . ' ' . $user->mname . ' ' . $user->lname));

        activity()
            ->performedOn($user)
            ->causedBy($user)
        ->withProperties(['role' => $user->role, 'status' => $user->status])
        ->log("$name uploaded their profile picture.");
        return response()->json(['message' => 'No image uploaded'], 400);
    }

    public function uploadBackground(Request $request)
{
    // Validate the uploaded files
    $request->validate([
        'photo1' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        'photo2' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        'photo3' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
    ]);

    $uploadedPhotos = [];

    // Process each photo and store it in the public directory
    foreach (['photo1', 'photo2', 'photo3'] as $photoKey) {
        if ($request->hasFile($photoKey)) {
            $file = $request->file($photoKey);
            $filePath = $file->store('uploads/photos', 'public');
            $uploadedPhotos[$photoKey] = $filePath;
        }
    }

    $user = Auth::user();
    // Get the authenticated user
    $user = Auth::user();
    $name = $user->role === 'Merchant'
    ? $user->business_name
    : ($user->role === 'Influencer'
        ? $user->blog_name
        : trim($user->fname . ' ' . $user->mname . ' ' . $user->lname));

    activity()
        ->performedOn($user)
        ->causedBy($user)
    ->withProperties(['role' => $user->role, 'status' => $user->status])
    ->log("$name uploaded their background photos.");
    return response()->json([
        'message' => 'Background Uploaded Successfully',
        'photos' => $uploadedPhotos,
    ]);
}


//     public function uploadBackground(Request $request)
// {
//     // Validate that all three photos are present

//     // Store each photo separately
//     if ($request->hasFile('photo1')) {
//         $photo1 = Storage::put('/photos/background', $request->file('photo1'));
//         $request->user()->update(['photo1' => $photo1]);
//     }

//     if ($request->hasFile('photo2')) {
//         $photo2 = Storage::put('/photos/background', $request->file('photo2'));
//         $request->user()->update(['photo2' => $photo2]);

//     }

//     if ($request->hasFile('photo3')) {
//         $photo3 = Storage::put('/photos/background', $request->file('photo3'));
//         $request->user()->update(['photo3' => $photo3]);

//     }

//     // Update user's data with the paths to the uploaded photos

//     return response()->json(['message' => 'Background Uploaded Successfully']);
// }






    public function changePassword(Request $request, UpdateUserPasswordAction $updater)
    {

        $updater->update(
            auth()->user(),
            [
                'current_password' => $request->currentPassword,
                'password' => $request->password,
                'password_confirmation' => $request->passwordConfirmation,
            ]
        );
        $user = Auth::user();
        // Get the authenticated user
        $user = Auth::user();
        $name = $user->role === 'Merchant'
        ? $user->business_name
        : ($user->role === 'Influencer'
            ? $user->blog_name
            : trim($user->fname . ' ' . $user->mname . ' ' . $user->lname));

        activity()
            ->performedOn($user)
            ->causedBy($user)
        ->withProperties(['role' => $user->role, 'status' => $user->status])
        ->log("$name changed their password.");
        return response()->json(['message' => 'Password change Successfuly']);
    }
}
