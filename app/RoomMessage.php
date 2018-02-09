<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class RoomMessage extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'room_id', 'user_id', 'message'
    ];

    protected $hidden = [

    ];

    public function room()
    {
        return $this->hasOne('App\ArticleRoom', 'id', 'room_id');
    }

    public function user()
    {
        return $this->hasOne('App\User', 'user_id', 'user_id');
    }

    public function scopeWithUser($query)
    {
        return $query->with(['user' => function($q) {
            $q->select('user_id', 'name');
        }]);
    }

    public function scopeUserMessage($query, $message_id, $user_id)
    {
        return $query->where('id', $message_id)->where('user_id', $user_id);
    }
}
