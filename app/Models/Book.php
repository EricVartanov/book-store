<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'cover',
        'author_id',
        'adult',
        'rating',
        'user_id',
    ];

    protected $casts = [
        'ratings_avg_rating' => 'decimal:1',
    ];

    //жанры
    public function genres()
    {
        return $this->belongsToMany(Genre::class);
    }

    //автор
    public function author()
    {
        return $this->belongsTo(User::class, 'author_id');
    }

    public function ratings()
    {
        return $this->hasMany(BookRating::class);
    }

    public function averageRating()
    {
        return round($this->ratings()->avg('rating'), 1);
    }
}
