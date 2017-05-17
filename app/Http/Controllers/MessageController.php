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
        return Message::withUser($user)->with('from', 'to')->latest()->paginate();
    }

    public function store(User $user)
    {
        $body = request('body');

        event(new IncomingMessage(Auth::user(), $user, $body));

        return [
            'from' => Auth::user()->name,
            'to' => $user->name,
            'message' => $body
        ];
    }
}
