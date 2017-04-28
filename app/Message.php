<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Auth;

class Message extends Model
{
    protected $fillable = ['from_user_id', 'to_user_id', 'body'];

    public function from()
    {
        return $this->belongsTo(User::class, 'from_user_id');
    }

    public function to()
    {
        return $this->belongsTo(User::class, 'to_user_id');
    }

    public function scopeFromUser($query, $user)
    {
    	return $query->where(function ($query) use ($user) {
    		$query->where('from_user_id', $user->id)->where('to_user_id', Auth::id());
    	})->orWhere(function ($query) use ($user) {
    		$query->where('from_user_id', Auth::id())->where('to_user_id', $user->id);
    	});
    }

    public function scopeMy($query)
    {
        return $query->where('from_user_id', Auth::id())->orWhere('to_user_id', Auth::id());
    }
}
