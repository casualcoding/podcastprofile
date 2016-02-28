<?php

namespace App\Models;

use App\Jobs\UpdatePodcastFromRss;
use DB;
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
     * The feed urls that belong to the podcast.
     */
    public function feeds()
    {
        return $this->hasMany('App\Models\Feed');
    }

    /**
     * Get the top Podcasts.
     *
     * @param int $count
     * @return List
     */
    public static function getTop($count)
    {
        $podcasts = Podcast::join('podcast_user', 'podcast_user.podcast_id', '=', 'podcasts.id')
            ->groupBy('podcasts.id')
            ->orderBy(DB::raw('count(podcast_user.id)'), 'desc')
            ->take($count)
            ->get([
                'podcasts.name',
                'podcasts.url',
                'podcasts.feed',
                'podcasts.coverimage',
                'podcasts.description',
                DB::raw('count(podcast_user.id) as podcast_user_count')]);

        return $podcasts;
    }

    /**
     * Get podcast from feed.
     * Create new podcast if necessary.
     *
     * @param string $feed
     * @return Podcast
     */
    public static function getOrCreateFromRss($feed_url)
    {
        $created = false;
        $podcast = Podcast::whereHas('feeds', function($query) use ($feed_url) {
            $query->where('url', $feed_url);
        })->first();
        if (!$podcast) {
            $podcast = new Podcast;
            $podcast->coverimage = '/assets/default.png';
            $podcast->save();

            $feed = new Feed;
            $feed->url = $feed_url;
            $podcast->feeds()->save($feed);

            // load feed details asynchronously
            dispatch(new UpdatePodcastFromRss($podcast));
            $created = true;
        }
        return $podcast;
    }
}
