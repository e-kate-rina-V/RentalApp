<?php

namespace App\Http\Controllers;

use App\Events\MessageSent;
use App\Models\Chat;
use App\Models\Message;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class MessageController extends Controller
{
    public function getMessages($chatId)
    {
        $chat = Chat::findOrFail($chatId);
        return response()->json(['messages' => $chat->messages]);
    }

    public function sendMessage(Request $request, $chatId)
    {
        $request->validate([
            'message' => 'required|string',
        ]);

        $chat = Chat::findOrFail($chatId);
        $userId = auth()->id();

        $message = Message::create([
            'chat_id' => $chatId,
            'user_id' => $userId,
            'message' => $request->message,
        ]);

        broadcast(new MessageSent($chat, $message));

        $messages = $chat->messages; 

        return response()->json(['messages' => $messages]); 
    }
}
