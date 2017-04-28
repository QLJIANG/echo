<?php

namespace App\Http\Controllers;

use Auth;
use App\User;
use App\Message;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('home');
    }

    public function message()
    {
        $messages = Message::my()->get()->sortByDesc('created_at')->unique(function ($message) {
            return $message->from_user_id * $message->to_user_id;
        })->load('from', 'to');

        return $messages;
    }
}
