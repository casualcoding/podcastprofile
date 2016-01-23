<?php namespace App\Http\Controllers;

use App\Models\User;
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

        // $user = Auth::user();
        $xml = $request->file('xml');

        // TODO: call parser

        return response()->json(['success' => true]);
    }
}
