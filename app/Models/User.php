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
        'name', 'avatar', 'url', 'handle', 'twitter_id', 'privacy_policy_accepted_date'
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
     * All podcasts that belong to the user.
     */
    public function podcasts()
    {
        return $this->belongsToMany('App\Models\Podcast')
            ->where('error', 0)
            ->withPivot('description', 'position', 'visible')
            ->orderBy('position', 'asc');
    }

    /**
     * The public podcasts that belong to the user.
     */
    public function podcastsPublic()
    {
        return $this->podcasts()
            ->wherePivot('visible', true);
    }

    /**
     * Add podcast at the position.
     *
     * @param Podcast $podcast
     * @param int $pos
     * @return bool
     */
    public function addPodcast($podcast, $pos)
    {
        $created = false;

        if (!$this->podcasts()->where('podcast_id', $podcast->id)->exists()) {
            $this->podcasts()->save($podcast, [
                'position' => $pos,
                'visible' => true]);
            $created = true;
        }

        return $created;
    }

    /**
     * Return a random unique handler
     *
     * @return String
     */
    public function generateUniqueHandler()
    {
        $handle = str_random(40);
        while(User::where('handle', $handle)->first()) {
            $handle = str_random(40);
        }
        return $handle;
    }

    /**
     * Return position where the next podcast can be inserted.
     *
     * @return String
     */
    public function getNewPodcastPosition()
    {
        $pos = $this->podcasts()
            ->max('position');
        return is_null($pos) ? 0 : $pos+1;
    }

    /**
     * Checks if the user is an admin.
     *
     * @return boolean
     */
    public function isAdmin()
    {
        return $this->role == Role::$admin;
    }

    /**
     * Checks if the user has accepted the latest privacy policy.
     * 
     * @return boolean
     */
    public function hasAcceptedPrivacyPolicy()
    {
        $acceptedDate = new \DateTime($this->privacy_policy_accepted_date);
        $latestUpdate = new \DateTime('2018-05-21');
        return ($acceptedDate > $latestUpdate);
    }
}
