<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class MenuRole extends Model
{
  use SoftDeletes;

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
     protected $casts = [ 'id' => 'integer', 'menu_id' => 'integer', 'role_id' => 'integer' ];

     protected $fillable = [
       'menu_id', 'role_id'
     ];

     protected $hidden = [

     ];

    protected $dates = ['deleted_at'];
}
