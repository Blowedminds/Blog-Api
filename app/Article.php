<?php

namespace App;

use App\Traits\NPerGroup;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Article extends Model
{
    use SoftDeletes;
    use NPerGroup;
    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['deleted_at'];

    protected $casts = ['id' => 'integer', 'views' => 'integer'];

    protected $fillable = [
        'slug', 'author_id', 'image', 'views'
    ];

    protected $hidden = [

    ];

    public function languages()
    {
        return $this->belongsToMany('App\Language', 'article_contents', 'article_id', 'language_id');
    }

    public function availableLanguages($published = 1)
    {
        return $this->belongsToMany('App\Language', 'article_contents', 'article_id', 'language_id')->wherePivot('published', $published);
    }

    public function categories()
    {
        return $this->belongsToMany('App\Category', 'article_categories');
    }

    public function article_categories()
    {
        return $this->hasMany('App\ArticleCategory');
    }

    public function users()
    {
        return $this->belongsToMany('App\User', 'article_permissions', 'article_id', 'user_id');
    }

    public function permissions()
    {
        return $this->hasMany('App\ArticlePermission');
    }

    public function contents()
    {
        return $this->hasMany('App\ArticleContent');
    }

    public function content()
    {
        return $this->hasOne('App\ArticleContent');
    }

    public function author()
    {
        return $this->belongsTo('App\User', 'author_id', 'user_id');
    }

    public function olds()
    {
        return $this->hasMany('App\ArticleArchive', 'article_id', 'id');
    }

    public function contentByLanguage($language)
    {
        return $this->hasOne('App\\ArticleContent')->where('language_id', $language);
    }

    public function trashed_categories()
    {
        return $this->hasMany('App\ArticleCategory')->onlyTrashed();
    }

    public function trashed_contents()
    {
        return $this->hasMany('App\ArticleContent', 'article_id', 'id')->onlyTrashed();
    }

    public function room()
    {
        return $this->hasOne('App\ArticleRoom');
    }

    public function createMessage($message)
    {
        $new_message = $this->room->messages()->create([
            'room_id' => $this->room->id,
            'user_id' => auth()->user()->user_id,
            'message' => $message
        ]);

        return $new_message;
    }

    public function scopeWhereHasContent($query, $language_id)
    {
        return $query->whereHas('content', function ($query_content) use ($language_id) {
            $query_content->where('language_id', $language_id);
        });
    }

    public function scopeWithContent($query, $language_id)
    {
        return $query->with(['content' => function ($query_content) use ($language_id) {
            $query_content->where('language_id', $language_id);
        }]);
    }

    public function scopeWhereHasPublishedContent($query, $language_id, $published = 1)
    {
        return $query->whereHas('content', function ($query_content) use ($language_id, $published) {
            $query_content->where('language_id', $language_id)->published($published);
        });
    }

    public function scopeWithPublishedContent($query, $language_id, $published = 1)
    {
        return $query->with(['content' => function ($query_content) use ($language_id, $published) {
            $query_content->where('language_id', $language_id)->published($published);
        }]);
    }

    public function scopeSlug($query, $slug)
    {
        return $query->where('slug', $slug);
    }

    public function scopeWhereId($query, $id)
    {
        return $query->where('id', $id);
    }

    public function scopeWithRoomAndMessages($query)
    {
        return $query->with(['room' => function ($q) {
            $q->withMessagesAndUser();
        }]);
    }
}
