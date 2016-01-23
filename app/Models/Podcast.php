<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Podcast extends Model
{
    /**
     * The users that belong to the podcast.
     */
    public function users()
    {
        return $this->belongsToMany('App\Models\User')
            ->withPivot('position', 'description', 'visible')
            ->withTimestamps();
    }
}
