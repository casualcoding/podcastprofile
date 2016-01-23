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
        'name', 'realname', 'avatar', 'url', 'handle', 'twitter_id',
    ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [
        'remember_token',
    ];

    /**
     * The podcasts that belong to the user.
     */
    public function podcasts()
    {
        return $this->belongsToMany('App\Podcast');
    }
}
