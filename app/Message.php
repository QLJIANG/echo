<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Auth;
use Carbon\Carbon;

/**
 * App\Message
 *
 * @property-read \App\Chat $chat
 * @property-read \App\User $from
 * @property-read mixed $created_at
 * @property-read \App\User $to
 * @method static \Illuminate\Database\Query\Builder|\App\Message my()
 * @method static \Illuminate\Database\Query\Builder|\App\Message withUser($user)
 * @mixin \Eloquent
 */
class Message extends Model
{
    protected $fillable = ['from_user_id', 'to_user_id', 'from_to', 'body'];

    public function from()
    {
        return $this->belongsTo(User::class, 'from_user_id');
    }

    public function to()
    {
        return $this->belongsTo(User::class, 'to_user_id');
    }

    public function scopeWithUser($query, $user)
    {
    	return $query->where('from_to', Auth::id() * $user->id);
    }

    public function scopeMy($query)
    {
        return $query->where('from_user_id', Auth::id())->orWhere('to_user_id', Auth::id());
    }

    public function chat()
    {
        return $this->belongsTo(Chat::class);
    }

    public function getCreatedAtAttribute($value)
    {
        return Carbon::parse($value)->diffForHumans();
    }
}
