<?php

namespace App\Http\Controllers;

use App\Events\IncomingMessage;
use App\User;
use Auth;
use App\Message;

class MessageController extends Controller
{
    public function index(User $user)
    {
        return Message::fromUser($user)->with('from', 'to')->latest()->paginate(10);
    }

    public function store()
    {
        $from = Auth::user();
        $to = User::find(request('to'));
        $body = request('body');

        event(new IncomingMessage($from, $to, $body));

        return [
            'from' => $from->name,
            'to' => $to->name,
            'message' => $body
        ];
    }
}
