<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Book extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function author() : BelongsToMany {
        return $this->belongsToMany(User::class, 'author_id', 'id');
    }
    
    public function publisher() : BelongsToMany {
        return $this->belongsToMany(User::class, 'publisher_id', 'id');
    }
}
