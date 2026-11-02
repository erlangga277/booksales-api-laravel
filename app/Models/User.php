<?php

namespace App\Models;

use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

#[Fillable(['name', 'email', 'password', 'role', 'last_access'])]
#[Hidden(['password', 'remember_token'])]
class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasApiTokens, HasFactory, Notifiable;

    public $timestamps = false;

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'last_access'       => 'datetime',
            'password'          => 'hashed',
        ];
    }

    // Relasi ke Transaction (customer_id)
    public function transactions(): HasMany
    {
        return $this->hasMany(Transaction::class, 'customer_id');
    }
}