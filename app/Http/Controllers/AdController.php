<?php

namespace App\Http\Controllers;

use App\Models\Ad;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class AdController extends Controller
{
    public function ad_register(Request $request)
    {
        if (!auth()->check()) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }

        Log::info('Request data:', $request->all());

        $validateAd = Validator::make($request->all(), [
            'title' => "required|string|max:255",
            'description' => "required|string|max:1000",
            'prem_type' => 'required|in:house,flat,hotel_room',
            'accom_type' => 'required|in:entire_place,private_room,shared_room',
            'guest_count' => 'required|integer|min:1',
            'price' => 'required|numeric|min:1',
            // 'conven' => 'array',
            // 'conven.*' => 'string',
            // 'materials' => 'array',
            // 'materials.*' => 'file|mimes:jpeg,png,jpg,mp4,mov|max:2048'
        ]);

        if ($validateAd->fails()) {
            return response()->json([
                'message' => 'Validation failed',
                'errors' => $validateAd->errors()
            ], 422);
        }

        try {
            $ad = new Ad();
            $ad->title = $request->input('title');
            $ad->description = $request->input('description');
            $ad->prem_type = $request->input('prem_type');
            $ad->accom_type = $request->input('accom_type');
            $ad->guest_count = $request->input('guest_count');
            $ad->price = $request->input('price');
            $ad->user_id = auth()->id();
            $ad->save();

            return response()->json(['message' => 'Ad registered successfully'], 200);
        } catch (\Exception $e) {
            Log::error('Error saving ad:', ['error' => $e->getMessage()]);

            return response()->json([
                'message' => 'Failed to register ad',
                'error' => $e->getMessage()
            ], 500);
        }

        // DB::beginTransaction();

        // try {
        //     $ad = Ad::create(array_merge(
        //         $request->only(['title', 'description', 'prem_type', 'accom_type', 'guest_count', 'price']),
        //         ['user_id' => auth()->id()]
        //     ));

        //     if ($request->has('conven')) {
        //         $ad->conveniences()->createMany(
        //             collect($request->conven)->map(fn($name) => ['name' => $name])->toArray()
        //         );
        //     }

        //     if ($request->hasFile('materials')) {
        //         $ad->materials()->createMany(
        //             collect($request->file('materials'))->map(function ($file) {
        //                 $path = $file->store('uploads', 'public');
        //                 return ['source' => $path];
        //             })->toArray()
        //         );
        //     }


        //     DB::commit();

        //     return response()->json([
        //         'message' => 'Ad registered successfully',
        //         'ad' => $ad
        //     ], 201);
        // } catch (\Exception $e) {
        //     DB::rollBack();

        //     return response()->json([
        //         'message' => 'Failed to register ad',
        //         'error' => $e->getMessage()
        //     ], 500);
        // }

        // if (!auth()->check()) {
        //     return response()->json(['message' => 'Unauthorized'], 401);
        // }
    }
}
