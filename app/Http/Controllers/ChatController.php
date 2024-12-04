<?php

namespace App\Http\Controllers;

use App\Models\Chat;
use App\Models\Message;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ChatController extends Controller
{
    public function createChat(Request $request)
    {

        $chat = Chat::create(['title' => $request->input('title')]);

        $chat->users()->attach(auth()->id());
        $chat->users()->attach($request->input('user_id'));

        return response()->json($chat);
    }

    public function getChats()
    {
        if (!Auth::check()) {
            return response()->json(['error' => 'User not authenticated'], 401);
        }

        $chats = Auth::user()->chats()->with('messages')->get();

        return response()->json($chats);
    }

    public function getMessages($chatId)
    {
        $chat = Chat::findOrFail($chatId); 
        $messages = $chat->messages; 

        return response()->json($messages);
    }

    public function sendMessage(Request $request, $chatId)
    {
        $chat = Chat::findOrFail($chatId); 

        $request->validate([
            'content' => 'required|string',
        ]);

        $message = new Message();
        $message->chat_id = $chatId;
        $message->user_id = $request->user()->id; 
        $message->content = $request->content;
        $message->save();

        return response()->json($message);
    }
}
