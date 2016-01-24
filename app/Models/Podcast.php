<?php

namespace App\Models;

use App\Jobs\UpdatePodcastFromRss;
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

    /**
     * Get podcast from feed.
     * Create new podcast if necessary.
     *
     * @param string $feed
     * @return Podcast
     */
    public static function getOrCreateFromRss($feed)
    {
        $created = false;
        $podcast = Podcast::where('feed', $feed)->first();
        if (!$podcast) {
            $podcast = new Podcast;
            $podcast->feed = $feed;
            $podcast->save();

            // load feed details asynchronously
            dispatch(new UpdatePodcastFromRss($podcast));
            $created = true;
        }
        return $podcast;
    }
}
