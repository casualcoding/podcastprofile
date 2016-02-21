<?php namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Podcast;
use App\Services\FeedService;
use Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Validator;
use Image;

// TODO delete this when postDeleteAccounts returns a JSON response
use Illuminate\Support\Facades\Redirect;

class ProfileApiController extends Controller
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
        $user->url = Input::get('url');
        $user->save();

        return $user->toJson();
    }

    /**
     * Upload the user profile image.
     *
     * @return Response
     */
    public function postProfileImage(Request $request)
    {
        $user = Auth::user();

        $rules = array('image' => 'required|image',);
        $validator = Validator::make(Input::all(), $rules);

        if ($validator->passes()) {
            $public_path = '/images/';
            $internal_path = __DIR__ . '/../../../public';
            $path = $internal_path . $public_path;
            $extension = Input::file('image')->getClientOriginalExtension();
            $filename = md5($user->twitter_id).'.'.$extension;

            // checking file is valid.
            if (Input::file('image')->isValid()) {
                try {
                    unlink($internal_path . $user->avatar);
                } catch (\Exception $e) {
                    // if old image not there do nothing
                }
                Image::make(Input::file('image'))->fit(400, 400)->save($path.$filename);
                $user->avatar = $public_path.$filename;
                $user->save();
            }
        }
        if ($request->ajax()) {
            return $user->toJson();
        } else {
            return redirect()->route('settings');
        }
    }

    /**
     * Set description, position and visibility for list of podcasts.
     *
     * @param  Request  $request
     * @return Response
     */
    public function postUpdatePodcasts(Request $request)
    {
        $user = Auth::user();
        $podcasts = Input::get('podcasts');

        foreach ($podcasts as $podcast) {
            $user->podcasts()->updateExistingPivot($podcast['id'], [
                'description' => $podcast['description'],
                'visible' => $podcast['visible'],
                'position' => $podcast['position'],
            ]);
        }

        return response()->json(['success' => true]);
    }

    /**
     * Save podcasts from rss xml string.
     *
     * @param  Request  $request
     * @return Response
     */
    public function postPodcastByRss(Request $request)
    {
        $user = Auth::user();
        $feed = Input::get('feed_url');
        $podcast = Podcast::getOrCreateFromRss($feed);
        $pos = $user->getNewPodcastPosition();
        $created = $user->addPodcast($podcast, $pos);

        return response()->json([
            'success' => true,
            'podcast' => $podcast,
            'created' => $created
        ]);
    }

    /**
     * Save podcasts from uploaded opml file.
     *
     * @param  Request  $request
     * @return Response
     */
    public function postPodcastsByOpml(Request $request, FeedService $parser)
    {
        if (!$request->hasFile('xml')) {
            return response()->json(['error' => 'No file.'], $status = 500);
        } elseif (!$request->file('xml')->isValid()) {
            return response()->json(['error' => 'File invalid.'], $status = 500);
        }

        $user = Auth::user();
        $file = $request->file('xml');
        $pos = $user->getNewPodcastPosition();
        $new = [];

        try {
            $feeds = $parser->parseOpml($file);
        } catch (\Exception $e) {
            return response()->json(['error' => 'File could not be parsed.'], $status = 500);
        }

        foreach ($feeds as $feed) {
            $podcast  = Podcast::getOrCreateFromRss($feed);
            $created = $user->addPodcast($podcast, $pos);
            if ($created) {
                $pos++;
                $new[] = $podcast;
            }
        }

        return response()->json([
            'success' => true,
            'new' => $new,
            'feeds' => $feeds
        ]);
    }

    /**
     * Deletes the current user's account.
     *
     * @return Response
     */
    public function postDeleteAccount()
    {
        $user = Auth::user();
        $user->delete();

        // return response()->json([
        //     'success' => true
        // ]);
        return Redirect::route('auth::logout');
    }
}
