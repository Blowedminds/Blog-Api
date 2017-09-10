<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ArticlePermission extends Model
{
  protected $fillable = [
    'article_id', 'user_id'
  ];

  protected $hidden = [

  ];

}
