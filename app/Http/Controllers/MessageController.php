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
        $chat = Chat::where('id', $chatId)
                    ->where(function ($query) {
                        $query->where('user1_id', auth()->id())
                              ->orWhere('user2_id', auth()->id());
                    })
                    ->with(['messages.user', 'ad'])  
                    ->firstOrFail();

        $chatTitle = $chat->ad->title;  

        $messages = $chat->messages->map(function ($message) {
            return [
                'id' => $message->id,
                'user_id' => $message->user_id,
                'user_name' => $message->user->name, 
                'message' => $message->message,
            ];
        });
    
        return response()->json([
            'current_user_id' => auth()->id(),
            'chat_id' => $chat->id,
            'chat_title' => $chatTitle,  
            'messages' => $messages,
        ]);
    }
    

    public function sendMessage(Request $request, $chatId)
    {
        $request->validate([
            'message' => 'required|string',
        ]);

        $chat = Chat::where(function ($query) {
            $query->where('user1_id', auth()->id())
                ->orWhere('user2_id', auth()->id());
        })->findOrFail($chatId);

        $userId = auth()->id();
        $userName = auth()->user()->name;

        $message = Message::create([
            'chat_id' => $chatId,
            'user_id' => $userId,
            'message' => $request->message,
        ]);

        broadcast(new MessageSent($chat, $message));

        $messages = $chat->messages->map(function ($message) use ($userName) {
            return [
                'id' => $message->id,
                'user_id' => $message->user_id,
                'user_name' => $message->user->name,
                'message' => $message->message,
            ];
        });

        return response()->json([
            'user_id' => $userId,
            'user_name' => $userName,
            'messages' => $messages,
        ]);
    }
}
