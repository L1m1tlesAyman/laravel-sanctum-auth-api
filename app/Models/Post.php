<?php

namespace App\Models;

use Dom\Comment;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Post extends Model
{
    protected $fillable = [
        'title',
        'body',
        'user_id'
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(Post::class);
    }

    public function comments(){
        return $this->hasMany(Comment::class);
    }
}
