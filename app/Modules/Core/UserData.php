<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class UserData extends Model
{
  use SoftDeletes;

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['deleted_at'];

    protected $casts = [
        'id' => 'integer',
        'role_id' => 'integer',
        'biography' => 'array'
    ];

    protected $fillable = [
      'user_id', 'name', 'role_id', 'profile_image', 'biography'
    ];
}
