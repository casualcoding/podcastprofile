<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use TwitterAPIExchange;

trait TwitterApi
{
    /**
     * Recursively update twitter nicknames of users and change them
     *
     */
    public function recursiveUpdateNicknames($user)
    {
        $current_nick = $this->getNickFromTwitter($user->twitter_id);
        if ($current_nick != $user->handle) {
            $nickUser = User::where('handle', $current_nick)->first();
            if ($nickUser) {
                $this->recursiveUpdateNicknames($nickUser);
            }
            $user->handle = $current_nick;
            $user->save();
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
