<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Chat
 *
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Message[] $messages
 * @method static \Illuminate\Database\Query\Builder|\App\Chat my()
 * @mixin \Eloquent
 */
class Chat extends Model
{
    protected $fillable = ['from', 'to', 'message'];

    public function scopeMy($query)
    {
        return $query->where('from', \Auth::id())->orWhere('to', \Auth::id());
    }

    public function messages()
    {
        return $this->hasMany(Message::class);
    }
}
