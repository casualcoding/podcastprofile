<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Auth;
use Illuminate\Foundation\Auth\ThrottlesLogins;
use Illuminate\Foundation\Auth\AuthenticatesAndRegistersUsers;
use InvalidArgumentException;
use Socialite;
use Validator;
use TwitterAPIExchange;

class AuthController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Registration & Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users, as well as the
    | authentication of existing users. By default, this controller uses
    | a simple trait to add these behaviors. Why don't you explore it?
    |
    */

    use AuthenticatesAndRegistersUsers, ThrottlesLogins;

    protected $loginPath = '/';

    /**
     * Where to redirect users after login / registration.
     *
     * @var string
     */
    protected $redirectTo = '/';

    /**
     * Create a new authentication controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest', ['except' => 'logout']);
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => 'required|max:255',
            'email' => 'required|email|max:255|unique:users',
            'password' => 'required|confirmed|min:6',
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return User
     */
    protected function create(array $data)
    {
        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => bcrypt($data['password']),
        ]);
    }

    // http://goodheads.io/2015/08/24/using-twitter-authentication-for-login-in-laravel-5/
    // protected $redirectPath = '/home';

    /**
     * Redirect the user to the Twitter authentication page.
     *
     * @return Response
     */
    public function redirectToProvider()
    {
        return Socialite::driver('twitter')->redirect();
    }

    /**
     * Obtain the user information from Twitter.
     *
     * @return Response
     */
    public function handleProviderCallback()
    {
        try {
            $user = Socialite::driver('twitter')->user();
        } catch (InvalidArgumentException $e) {
            return redirect('/');
        } catch (Exception $e) {
            return redirect('auth/twitter');
        }

        $authUser = $this->findOrCreateUser($user);

        Auth::login($authUser, true);

        if (Auth::check()) {
            return redirect()->route('profile', ['handle' => $authUser->handle]);
        } else {
            return redirect('/');
        }
    }

    /**
     * Return user if exists; create and return if doesn't
     *
     * @param $twitterUser
     * @return User
     */
    private function findOrCreateUser($twitterUser)
    {
        $authUser = User::where('twitter_id', $twitterUser->id)->first();
        $nickUser = User::where('handle', $twitterUser->nickname)->first();

        if ($authUser) {
            if ($authUser->handle != $twitterUser->nickname) {
                if (!$nickUser) {
                    $authUser->handle = $twitterUser->nickname;
                    $authUser->save();
                } else {
                    // $nickUser Infos von Twitter auslesen und rekursiv anpassen
                }
            }
            return $authUser;
        }

        // $this->recursiveCheckNicknames($authUser);
        if ($nickUser) {
            // $nickUser Infos von Twitter auslesen und rekursiv anpassen
            // $this->recursiveCheckNicknames($nickUser);
        }

        return User::create([
            'name' => $twitterUser->name,
            'handle' => $twitterUser->nickname,
            'twitter_id' => $twitterUser->id,
            'avatar' => $twitterUser->avatar_original
        ]);
    }

    /**
     * Logs user out
     *
     * @return Response
     */
    public function logout()
    {
        Auth::logout();

        return redirect('/');
    }

    /**
     * Recursively check twitter nicknames of users and change them
     *
     * @return Boolean
     */
    private function recursiveCheckNicknames($user)
    {
        $settings = array(
            'oauth_access_token' => env('TWITTER_ACCESS_TOKEN'),
            'oauth_access_token_secret' => env('TWITTER_ACCESS_TOKEN_SECRET'),
            'consumer_key' => env('TWITTER_CONSUMER_KEY'),
            'consumer_secret' => env('TWITTER_COMSUMER_SECRET')
        );
        $url = 'https://api.twitter.com/1.1/users/show.json';
        $getfield = '?user_id='.$user->twitter_id;
        $requestMethod = 'GET';
        $twitter = new TwitterAPIExchange($settings);
        die($twitter->setGetfield($getfield)
            ->buildOauth($url, $requestMethod)
            ->performRequest());
    }
}
