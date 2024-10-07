<?php

namespace App\Http\Controllers;

use App\Models\Influencer;
use Illuminate\Http\Request;

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
            ->select('influencers.id AS influencer_id', 'influencers.*', 'users.*')
            ->leftJoin('users', 'influencers.user_id', '=', 'users.id')
            ->when(request('query'), function ($query, $searchQuery) use ($searchFields) {
                $query->where(function ($query) use ($searchFields, $searchQuery) {
                    foreach ($searchFields as $field) {
                        $query->orWhere($field, 'like', "%{$searchQuery}%");
                    }
                });
            })
            ->where('users.status', '!=', '0')
            ->get();

        return response()->json($influencers);
    }

}
