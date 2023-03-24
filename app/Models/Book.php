<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Book extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'book_title',
        'book_synopsis',
        'order',
    ];

    public function human(): BelongsTo
    {
        return $this->belongsTo(User:: class, 'order', 'id');
    }

    
    public function reviews(): HasMany
    {
        return $this->hasMany(Review::class, 'book_id', 'id');
    }
}
