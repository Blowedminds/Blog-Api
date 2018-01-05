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

    protected $guarded = [];

    public function menuRoles()
    {
      return $this->hasMany('App\MenuRole');
    }
}
