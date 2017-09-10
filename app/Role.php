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
    protected $dates = ['deleted_at'];

    public function menus()
    {
      return $this->belongsToMany('App\Menu', 'menu_roles', 'role_id', 'menu_id');
    }

    public function users()
    {
      return $this->belongsToMany('App\User', 'user_roles', 'role_id', 'user_id');
    }
}
