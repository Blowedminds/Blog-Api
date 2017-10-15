<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Menu extends Model
{
  use SoftDeletes;

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['deleted_at'];

    protected $casts = [ 'id' => 'integer', 'menu_weight' => 'integer', 'menu_parent' => 'integer' ];

    protected $fillable = [
      'menu_name', 'menu_url', 'menu_tooltip', 'menu_weight', 'menu_parent'
    ];

    protected $hidden = [

    ];


    public function menuRoles()
    {
      return $this->hasMany('App\MenuRole');
    }
}
