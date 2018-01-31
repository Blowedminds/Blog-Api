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
}
