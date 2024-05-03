<?php

namespace App\Http\Controllers;

use App\Models\Star;
use Illuminate\Http\Request;

class StarController extends Controller
{
    public function index()
    {
        $star = Star::query()->get();
        return response()->json($star);
    }
    public function update(Request $request){
        $validated = $request->validate([
            "stars" => "required|numeric",
            "id" => "required|exists:stars,id", // Siguraduhin na ang ID ay umiiral sa database
        ]);

        $star = Star::findOrFail($validated['id']);
        $newStars = $star->stars + $validated['stars'];

        if($newStars > 50000) {
            return response()->json(['message' => 'Stars exceeded the maximum limit of 50,000'], 422); // Ayusin ang maximum limit at HTTP status code
        }

        $star->stars += $validated['stars']; // Dapat ito ay nadagdag sa kasalukuyang halaga ng bituin
        $star->save(); // I-save ang pagbabago

        // I-return ang mensahe ng tagumpay
        return response()->json(['message' => 'Stars Added Completely']);
    }

}
