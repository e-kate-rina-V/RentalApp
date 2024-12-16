<?php

namespace App\Http\Controllers;

use App\Http\Requests\RegisterAdRequest;
use App\Models\Ad;
use App\Models\Convenience;
use App\Models\Material;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class AdController extends Controller
{
    public function showAllAds(Request $request): JsonResponse
    {
        $ads = Ad::with(['materials', 'conveniences'])
            ->filterByPremType($request->premType)
            ->filterByAccomType($request->accomType)
            ->filterByPriceRange($request->priceRange)
            ->filterByGuestCount($request->guestCount)
            ->filterByConveniences($request->conveniences)
            ->paginate(10);

        return response()->json($ads);
    }

    public function registerAd(RegisterAdRequest $request): JsonResponse
    {
        $ad = new Ad();
        $ad->fill([
            'title' => $request->title,
            'description' => $request->description,
            'prem_type' => $request->prem_type,
            'accom_type' => $request->accom_type,
            'guest_count' => (int) $request->guest_count,
            'price' => (float) $request->price,
            'user_id' => auth()->id(),
        ]);

        $ad->save();

        if ($request->has('conven')) {
            foreach ($request->input('conven') as $convenience) {
                $convenienceModel = new Convenience();
                $convenienceModel->fill([
                    'name' => $convenience,
                ]);
                $ad->conveniences()->save($convenienceModel);  
            }
        }

        if ($request->hasFile('materials') && is_array($request->file('materials'))) {
            foreach ($request->file('materials') as $file) {
                $path = $file->store('materials', 'public');
                $material = new Material();
                $material->fill([
                    'source' => $path,
                ]);
                $ad->materials()->save($material);  
            }
        } else {
            Log::error('No materials files uploaded');
        }

        return response()->json(['message' => 'Ad registered successfully'], 200);
    }

    public function showAdById(int $id): JsonResponse
    {
        $ad = Ad::with(['materials', 'conveniences'])->find($id);

        if (!$ad) {
            return response()->json(['error' => 'Ad not found'], 404);
        }

        return response()->json($ad, 200);
    }

    public function showUserAds(): JsonResponse
    {
        $user = Auth::user();

        $ads = Ad::where('user_id', $user->id)
            ->with('materials')
            ->paginate(2);

        return response()->json($ads);
    }
}
