<?php

namespace App\Http\Controllers;

use Auth;
use App\Models\User;
use App\Models\Podcast;
use App\Services\FeedService;
use Illuminate\View\View;
use Illuminate\Http\Request;
use DB;

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

        $user = Auth::user();

        return view('settings', compact('user'));
    }
    
    public function getImpressum()
    {
        return view('impressum');
    }

    public function getTop()
    {
        // $user = (Auth::check() ? Auth::user() : null);
        // $user = Auth::user();
        // return view('top', ['user' => $user]);

        // $podcasts = DB::table('podcasts')
        //     ->belongsToMany('podcast_user')
        //     ->withPivot('podcast_id')
            // ->orderBy('pivot_play_count', 'desc');
            // ->with(array('podcast_user'))
            // ->join('podcast_user', 'podcasts.id', '=', 'podcast_user.podcast_id')
            // ->get();

        $podcasts = Podcast::getTop(10);

        // ->orderBy('podcast_user', 'desc')->get();

        return view('top', ['podcasts' => $podcasts]);
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
