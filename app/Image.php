<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Image extends Model
{
  /**
   * The attributes that are mass assignable.
   *
   * @var array
   */
  protected $fillable = [
      'u_id', 'hash', 'name', 'size', 'width', 'height', 'type', 'alt', 'owner', 'public'
  ];

  /**
   * The attributes that should be hidden for arrays.
   *
   * @var array
   */
  protected $hidden = [

  ];

}
