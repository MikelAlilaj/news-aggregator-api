<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserAuthor extends Model
{
    public function author()
    {
        return $this->belongsTo(Author::class, 'author_id');
    }
}
