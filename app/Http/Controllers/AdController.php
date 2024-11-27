<?php

namespace App\Http\Controllers;

use App\Models\Ad;
use App\Models\Convenience;
use App\Models\Material;
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

        $validateAd = Validator::make($request->all(), [
            'title' => "required|string|max:255",
            'description' => "required|string|max:1000",
            'prem_type' => 'required|in:house,flat,hotel_room',
            'accom_type' => 'required|in:entire_place,private_room,shared_room',
            'guest_count' => 'required|integer|min:1',
            'price' => 'required|numeric|min:1',
            'conven' => 'array',
            'conven.*' => 'string|max:255',
            'materials' => 'array',
            'materials.*' => 'file|mimes:jpeg,png,jpg,mp4,mov|max:2048',
        ]);

        if ($validateAd->fails()) {
            return response()->json([
                'message' => 'Validation failed',
                'errors' => $validateAd->errors(),
            ], 422);
        }

        try {
            DB::beginTransaction();

            $ad = Ad::create([
                'title' => $request->title,
                'description' => $request->description,
                'prem_type' => $request->prem_type,
                'accom_type' => $request->accom_type,
                'guest_count' => $request->guest_count,
                'price' => $request->price,
                'user_id' => auth()->id(),
            ]);

            if ($request->has('conven')) {
                foreach ($request->input('conven') as $convenience) {
                    Convenience::create([
                        'name' => $convenience,
                        'ad_id' => $ad->id,
                    ]);
                }
            }

            if ($request->hasFile('materials') && is_array($request->file('materials'))) {
                foreach ($request->file('materials') as $file) {
                    $path = $file->store('materials', 'public');
                    Material::create([
                        'source' => $path,
                        'ad_id' => $ad->id,
                    ]);
                }
            } else {
                Log::error('No materials files uploaded');
            }

            DB::commit();

            return response()->json(['message' => 'Ad registered successfully'], 200);
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error saving ad:', ['error' => $e->getMessage()]);

            return response()->json([
                'message' => 'Failed to register ad',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function show($id)
    {
        if (!is_numeric($id)) {
            return response()->json(['error' => 'Invalid ad ID'], 400);
        }

        $ad = Ad::find($id);
        if (!$ad) {
            return response()->json(['error' => 'Ad not found'], 404);
        }

        return response()->json($ad);
    }
}
