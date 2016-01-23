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
     * Create new user.
     *
     * @param  Request  $request
     * @param  string  $name
     * @return Response
     */
    public function postNewUser(Request $request, $name)
    {
        if (User::where('name', $name)->exists()) {
            return response()->json(['error' => 'user already exists.']);
        }

        # TODO: validation

        $user = new User;
        $user->name = $name;
        $user->handle = $request->handle;
        $user->save();

        return $user->toJson();
    }

    /**
     * Get the user profile and related podcasts.
     *
     * @param  string  $name
     * @return Response
     */
    public function getProfile($name)
    {
        $user = User::where('name', $name)->firstOrFail();
        return $user->toJson();
    }

    /**
     * Set the user profile.
     *
     * @return Response
     */
    public function postProfile()
    {
        $user = Auth::user();

        $user->name = Input::get('name');
        $user->realname = Input::get('realname');
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

        $pos = $user->podcasts()->count();

        foreach ($xml->body->outline as $outline) {
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
            }
        }

        return response()->json(['success' => true]);
    }
}
