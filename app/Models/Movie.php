<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Movie extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'year',
        'sinopse',
        'duration',
        'directors',
        'writers',
        'stars',
        'rating',
        'image'
    ];

    protected $appends = ['rating_average'];

    public function getRatingAverageAttribute()
    {
        return $this->ratings()->avg('rating');
    }

    public function ratings()
    {
        return $this->hasMany('App\Models\Rating');
    }

    protected $table = 'movies';
}
