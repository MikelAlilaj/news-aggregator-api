<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserCategory extends Model
{
    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }
}
