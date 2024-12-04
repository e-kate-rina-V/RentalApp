<?php

namespace App\Http\Controllers;

use App\Events\MessageSent;
use App\Models\Message;
use Illuminate\Http\Request;

class MessageController extends Controller
{
    public function sendMessage(Request $request)
    {
        $message = Message::create([
            'chat_id' => $request->input('chat_id'),
            'user_id' => auth()->id(),
            'content' => $request->input('content'),
        ]);

        broadcast(new MessageSent($message))->toOthers();

        return response()->json($message);
    }

    public function getMessages($chatId)
    {
        $messages = Message::where('chat_id', $chatId)->with('user')->get();
        return response()->json($messages);
    }
}
