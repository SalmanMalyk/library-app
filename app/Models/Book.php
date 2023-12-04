<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Book extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description'
    ];

    public function author() : BelongsToMany {
        return $this->belongsToMany(User::class, 'book_author', 'book_id', 'author_id', 'id', 'id')->withTimestamps();
    }
    
    public function publisher() : BelongsToMany {
        return $this->belongsToMany(User::class, 'book_publisher', 'book_id', 'publisher_id', 'id', 'id')->withTimestamps();
    }
}
