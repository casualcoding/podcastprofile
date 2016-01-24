<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'avatar', 'url', 'handle', 'twitter_id',
    ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [
        'remember_token', 'handle', 'twitter_id'
    ];

    /**
     * The podcasts that belong to the user.
     */
    public function podcasts()
    {
        return $this->belongsToMany('App\Models\Podcast');
    }

    /**
     * The podcasts that belong to the user.
     */
    public function podcastsPublic()
    {
        return $this->belongsToMany('App\Models\Podcast')
            ->wherePivot('visible', true)
            ->withPivot('description', 'position', 'visible')
            ->orderBy('pivot_position', 'asc');
    }
}
