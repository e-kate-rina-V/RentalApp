<?php

namespace App\Http\Controllers;

use App\Events\MessageSent;
use App\Models\Ad;
use App\Models\Chat;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ChatController extends Controller
{
    public function startChat($adId)
    {
        $ad = Ad::findOrFail($adId);

        $tenantUserId = auth()->id();

        $ownerUserId = $ad->user_id;

        $chat = Chat::where(function ($query) use ($tenantUserId, $ownerUserId) {
            $query->where('user1_id', $tenantUserId)
                ->where('user2_id', $ownerUserId);
        })->orWhere(function ($query) use ($tenantUserId, $ownerUserId) {
            $query->where('user1_id', $ownerUserId)
                ->where('user2_id', $tenantUserId);
        })->first();

        if (!$chat) {
            $chat = Chat::create([
                'user1_id' => $tenantUserId,
                'user2_id' => $ownerUserId,
                'ad_id' => $ad->id,
            ]);
        }

        return response()->json(['chat_id' => $chat->id]);
    }
}
