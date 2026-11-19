<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Book extends Model
{
    use HasFactory;

    protected $table = 'books';

    protected $fillable = [
        'title',
        'description',
        'price',
        'stock',
        'cover_photo',
        'genre_id',
        'author_id',
    ];

    protected $appends = ['cover_photo_url'];

    public function getCoverPhotoUrlAttribute(): ?string
    {
        if (!$this->cover_photo) {
            return null;
        }

        return url(Storage::url($this->cover_photo));
    }

    public function author()
    {
        return $this->belongsTo(Author::class, 'author_id');
    }

    public function genre()
    {
        return $this->belongsTo(Genre::class, 'genre_id');
    }

    public function transactions()
    {
        return $this->hasMany(Transaction::class, 'book_id');
    }
}
