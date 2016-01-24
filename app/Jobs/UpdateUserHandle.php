<?php

namespace App\Jobs;

use App\Jobs\Job;
use App\Models\User;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use TwitterAPIExchange;

class UpdateUserHandle extends Job implements ShouldQueue
{
    use InteractsWithQueue, SerializesModels;

    protected $user;

    /**
     * Create a new job instance.
     *
     * @param  User $user
     * @return void
     */
    public function __construct(User $user)
    {
        $this->user = $user;
    }

    /**
     * Recursively update twitter nicknames of users and change them
     *
     * @return void
     */
    public function handle()
    {
        $loop = true;
        while($loop) {
            $current_nick = $this->getNickFromTwitter($this->user->twitter_id);
            $nickUser = User::where('handle', $current_nick)->first();
            if ($nickUser) {
                // TODO if save fails make random string until save success
                $nickUser->handle = $nickUser->twitter_id;
                $nickUser->save();    
            } else {
                $loop = false;
            }
            $this->user->handle = $current_nick;
            $this->user->save();
            $this->user = $nickUser;
        }
    }

    /**
     * Contacts Twitter and gets the current nickname to a twitter ID
     *
     * @return String
     */
    private function getNickFromTwitter($twitter_id)
    {
        $settings = array(
            'oauth_access_token' => env('TWITTER_ACCESS_TOKEN'),
            'oauth_access_token_secret' => env('TWITTER_ACCESS_TOKEN_SECRET'),
            'consumer_key' => env('TWITTER_CONSUMER_KEY'),
            'consumer_secret' => env('TWITTER_COMSUMER_SECRET')
        );
        $url = 'https://api.twitter.com/1.1/users/show.json';
        $getfield = '?user_id='.$twitter_id;
        $requestMethod = 'GET';
        $twitter = new TwitterAPIExchange($settings);
        $json = json_decode($twitter->setGetfield($getfield)
            ->buildOauth($url, $requestMethod)
            ->performRequest());
        return $json->screen_name;
    }
}
