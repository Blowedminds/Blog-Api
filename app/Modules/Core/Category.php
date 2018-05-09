<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Category extends Model
{
  use SoftDeletes;

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */

    protected $casts = [ 'id' => 'integer' ];

    protected $fillable = [
      'name', 'description', 'slug'
    ];

    protected $hidden = [

    ];

    protected $dates = ['deleted_at'];

    public function articles()
    {
      return $this->belongsToMany('App\Article', 'article_categories');
    }

  /*  public function articleCategories()
    {
      return $this->hasMany('App\ArticleCategory');
    }*/

    public function articleContents()
    {
      return $this->hasManyThrough('App\ArticleContent', 'App\ArticleCategory', 'category_id', 'article_id', 'id', 'article_id');
    }

    public function scopeSlug($query, $slug)
    {
        return $query->where('slug', $slug);
    }
}
