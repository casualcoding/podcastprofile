<?php

namespace App\Http\Controllers;

use SimplePie;
use Illuminate\View\View;
use Illuminate\Http\Request;

class StaticController extends Controller
{

    public function getIndex()
    {
        return view('index');
    }

    public function getProfile()
    {
        return view('profile');
    }

    public function getSettings()
    {
        return view('settings');
    }

    public function postUpload(Request $request)
    {
        $file = $request->file('upload');
        $xml = simplexml_load_file($file);

        foreach ($xml->body->outline as $outline) {
            print_r((string) $outline['xmlUrl'].'<br>');
            // send feed url to the queue
        }

        // TODO render view or redirect
        return "<br>DONE";
    }
    
    public function testFeed()
    {
        $json = file_get_contents('https://itunes.apple.com/search?media=podcast&term=tech&limit=50');
        $podcasts = json_decode($json);

        $result = '';

        foreach($podcasts->results as $podcast) {
            $url = $podcast->feedUrl;
        
            $feed = new SimplePie();
            $feed->set_cache_location(__DIR__ . '/../../../cache');
            $feed->set_feed_url($url);
            $feed->init();

            $title = $feed->get_title();
            $link = $feed->get_link();
            $summary = $feed->get_channel_tags(SIMPLEPIE_NAMESPACE_ITUNES, 'summary')[0]['data'];
            $image = $feed->get_channel_tags(SIMPLEPIE_NAMESPACE_ITUNES, 'image')[0]['attribs']['']['href'];

            $result .= '<table>';
            $result .= '<tr><td><img src="' . $image . '" width=200 height=200></td>';
            $result .= '<td><h3>' . $title . '</h3>';
            $result .= $link . '<br>' . $summary;
            $result .= '</td></tr>';
            $result .= '</table>';
        }
        
        return $result;
    }


}
