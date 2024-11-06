<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserSource extends Model
{
    public function source()
    {
        return $this->belongsTo(Source::class, 'source_id');
    }
}
