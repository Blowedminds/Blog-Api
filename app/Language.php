<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Language extends Model
{
    use SoftDeletes;

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['deleted_at'];

    protected $casts = ['id' => 'integer'];

    protected $fillable = [
        'slug', 'name'
    ];

    public function getRouteKeyName()
    {
        return 'slug';
    }

    public function scopeSlug($query, $slug)
    {
        return $query->where('slug', $slug);
    }
}
