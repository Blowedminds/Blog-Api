<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Article extends Model
{
  use SoftDeletes;

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['deleted_at'];

    protected $casts = [ 'id' => 'integer', 'views' => 'integer' ];

    protected $fillable = [
      'slug', 'author', 'image', 'views'
    ];

    protected $hidden = [

    ];

    public function languages()
    {
      return $this->belongsToMany('App\Language', 'article_contents', 'article_id', 'language');
    }

    public function availableLanguages($published = 1)
    {
      return $this->belongsToMany('App\Language', 'article_contents', 'article_id', 'language')->wherePivot('published', $published);
    }

    public function categories()
    {
      return $this->belongsToMany('App\Category', 'article_categories', 'article_id', 'category_id');
    }

    public function article_categories()
    {
      return $this->hasMany('App\ArticleCategory');
    }

    public function users()
    {
      return $this->belongsToMany('App\User', 'article_permissions', 'article_id', 'user_id');
    }

    public function share_users()
    {
      return $this->hasMany('App\ArticlePermission');
    }

    public function contents()
    {
      return $this->hasMany('App\ArticleContent', 'article_id', 'id');
    }

    public function author()
    {
      return $this->belongsTo('App\User', 'author', 'user_id');
    }

    public function olds()
    {
      return $this->hasMany('App\ArticleArchive', 'article_id', 'id');
    }

    public function contentByLanguage($language)
    {
      return $this->hasOne('App\\ArticleContent')->where('language', $language);
    }

    public function trashed_categories()
    {
      return $this->hasMany('App\ArticleCategory')->onlyTrashed();
    }

    public function trashed_contents()
    {
      return $this->hasMany('App\ArticleContent', 'article_id', 'id')->onlyTrashed();
    }

}
