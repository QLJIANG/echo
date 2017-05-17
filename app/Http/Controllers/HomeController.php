<?php

namespace App\Http\Controllers;

use App\Chat;
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
        $messages = Message::my()->latest()->get()->unique('from_to')->load('from', 'to');

        return $messages;
    }
}
