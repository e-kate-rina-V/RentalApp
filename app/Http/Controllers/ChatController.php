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

        if ($tenantUserId === $ownerUserId) {
            return response()->json(['error' => 'You cannot start a chat with yourself.'], 400);
        }

        $chat = Chat::firstOrCreate(
            [
                'user1_id' => min($tenantUserId, $ownerUserId),
                'user2_id' => max($tenantUserId, $ownerUserId),
                'ad_id' => $ad->id,
            ]
        );

        return response()->json(['chat_id' => $chat->id]);
    }


    public function getUserChats()
    {
        $userId = auth()->id();
        $chats = Chat::where('user1_id', $userId)
            ->orWhere('user2_id', $userId)
            ->with(['user1', 'user2', 'ad'])
            ->get();
            
        return response()->json(['current_user_id' => $userId, 'chats' => $chats]);
    }
}
