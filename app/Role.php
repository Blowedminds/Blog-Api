<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class Role extends Model
{
  use SoftDeletes;

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */

    protected $casts = [ 'id' => 'integer' ];

    protected $dates = ['deleted_at'];

    protected $guarded = [];

    public function menus()
    {
      return $this->belongsToMany('App\Menu', 'menu_roles');
    }

    public function users()
    {
      return $this->belongsToMany('App\User', 'user_datas', 'role_id', 'user_id');
    }
}
