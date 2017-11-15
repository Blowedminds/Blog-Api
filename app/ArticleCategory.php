<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ArticleCategory extends Model
{
  use SoftDeletes;

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['deleted_at'];

    protected $casts = [ 'id' => 'integer', 'article_id' => 'integer', 'category_id' => 'integer' ];

    protected $fillable = [
      'article_id', 'category_id'
    ];

    protected $hidden = [

    ];

  /*  public function articleContents()
    {
      return $this->hasMany('App\ArticleContent', 'article_id');
    }*/
}
