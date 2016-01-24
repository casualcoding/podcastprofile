<?php namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Podcast;
use Auth;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Input;

class ProfileApiController extends BaseController
{

    /**
     * Set the user profile.
     *
     * @return Response
     */
    public function postProfile()
    {
        $user = Auth::user();

        $user->name = Input::get('name');
        $user->avatar = Input::get('avatar');
        $user->url = Input::get('url');
        $user->save();

        return $user->toJson();
    }

    /**
     * Save podcasts from uploaded opml file.
     *
     * @param  Request  $request
     * @return Response
     */
    public function postPodcastsByOpml(Request $request)
    {

        if (!$request->hasFile('xml')) {
            return response()->json(['error' => 'no file.']);
        } elseif (!$request->file('xml')->isValid()) {
            return response()->json(['error' => 'file invalid.']);
        }

        $user = Auth::user();
        $file = $request->file('xml');
        $xml = simplexml_load_file($file);

        $pos = $user->podcasts()
            ->withPivot('position')
            ->max('position');
        $added = [];

        // The standard OPML structure is
        // <body> <outline ... /> <outline ... /> </body> 
        $outlines = $xml->body->outline;
        
        // Pocket Casts and some other clients use the structure
        // <body> <outline> <outline ... /> <outline ... /> <outline> </body>
        if (isset($xml->body->outline->outline)) {
            $outlines = $xml->body->outline->outline;
        }
        
        foreach ($outlines as $outline) {
            $feed = (string) $outline['xmlUrl'];

            $podcast = Podcast::where('feed', $feed)->first();
            if (!$podcast) {
                $podcast = new Podcast;
                $podcast->feed = $feed;
                $podcast->save();

                // send feed url to the queue
            }

            if (!$user->podcasts()->where('feed', $feed)->exists()) {
                $user->podcasts()->save($podcast, [
                    'position' => $pos,
                    'visible' => true]);
                $pos++;
                $added[] = $podcast;
            }
        }

        return response()->json(['success' => true, 'new' => $added]);
    }
}
