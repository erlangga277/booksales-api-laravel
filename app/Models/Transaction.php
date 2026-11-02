<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Transaction extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_number',
        'customer_id',
        'book_id',
        'total_amount',
    ];

    // Relasi ke User (Customer)
    public function customer(): BelongsTo
    {
        return $this->belongsTo(User::class, 'customer_id');
    }

    // Relasi ke Book
    public function book(): BelongsTo
    {
        return $this->belongsTo(Book::class, 'book_id');
    }
}