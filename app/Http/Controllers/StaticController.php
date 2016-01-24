<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Services\FeedService;
use Illuminate\View\View;
use Illuminate\Http\Request;
use SimplePie;

class StaticController extends Controller
{
    public function getIndex()
    {
        return view('index');
    }

    public function getProfile($handle)
    {
        $user = User::where('handle', $handle)->firstOrFail();
        return view('profile', ['user' => $user]);
    }

    public function getSettings()
    {
        return view('settings');
    }

    public function testFeed(FeedService $parser)
    {
        $json = file_get_contents('https://itunes.apple.com/search?media=podcast&term=life&limit=50');
        $podcasts = json_decode($json);

        $result = '';

        foreach ($podcasts->results as $podcast) {
            $url = $podcast->feedUrl;

            $feed = $parser->loadDetailsFromRss($url);

            $result .= '<table>';
            $result .= '<tr><td><img src="'.$feed['image'].'" width=200 height=200></td>';
            $result .= '<td><h2>'.$feed['title'].'</h2>';
            $result .= '<p>'.$url.'</p><p>'.$feed['link'].'</p><p>'.$feed['summary'].'</p>';
            $result .= '</td></tr>';
            $result .= '</table>';
        }

        return $result;
    }
}
