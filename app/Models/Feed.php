<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Feed extends Model
{
    public function podcast()
    {
        return $this->belongsTo('App\Models\Podcast');
    }
}
