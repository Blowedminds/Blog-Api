<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ArticleContent extends Model
{
  use SoftDeletes;

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['deleted_at'];

    protected $casts = [ 'id' => 'integer', 'article_id' => 'integer', 'language_id' => 'integer', 'published' => 'integer', 'situation' => 'integer', 'version' => 'integer' ];

    protected $fillable = [
      'article_id', 'title', 'language', 'body', 'sub_title', 'keywords', 'published', 'situation', 'version'
    ];

    protected $hidden = [

    ];

    public function article()
    {
      return $this->belongsTo('App\Article');
    }
}
