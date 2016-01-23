<?php namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;

class ProfileApiController extends BaseController
{
    /**
     * Create new user.
     *
     * @param  Request  $request
     * @param  string  $name
     * @return Response
     */
    public function createUser(Request $request, $name)
    {
        if (User::where('name', $name)->exists()) {
            return response()->json(['error' => 'user already exists']);
        };

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
}
