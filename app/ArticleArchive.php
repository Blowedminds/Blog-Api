<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ArticleArchive extends Model
{
  use SoftDeletes;

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
  protected $dates = ['deleted_at'];

  protected $fillable = [
    'article_id', 'title', 'language', 'body', 'sub_title', 'keywords', 'published', 'situation', 'version'
  ];

  protected $hidden = [

  ];
}
