<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Book extends Model
{
    use HasFactory;

    protected $table = 'books';

    protected $fillable = [
        'title',
        'authors',
        'description',
        'cover_image',
        'pages',
        'language_code',
        'isbn',
        'in_stock',
    ];

    protected $dates = ['released_at'];

    public function borrows(): HasMany
    {
        return $this->hasMany(Borrow::class, 'book_id');
    }

    public function genres(): \Illuminate\Database\Eloquent\Relations\BelongsToMany
    {
        return $this->belongsToMany(Genre::class, 'book_genre', 'book_id', 'genre_id',)->withPivot(['book_id', 'genre_id']);
    }

    public function activeBorrows(): HasMany
    {
        return $this->borrows()->where('status', '=', 'ACCEPTED');
    }


}
