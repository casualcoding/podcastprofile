@extends('layouts.master')
@section('title', 'Show what podcasts you listen to')

@section('content')

<header class="site-block-home site-block-header uk-text-center">

    <div class="site-navigation-absolute">

        <div class="uk-navbar-flip">
            <ul class="uk-navbar-nav">
                @if (Auth::check())
                    <li><a href="/{{ Auth::user()->handle }}">Profile</a></li>
                    <li><a href="{{ URL::route('settings') }}">Settings</a></li>
                    <li><a href="{{ URL::route('auth::logout') }}">Logout</a></li>
                @else
                    <li><a href="{{ URL::route('auth::login') }}">Login</a></li>
                @endif
            </ul>
        </div>
    </div>


    <div class="uk-block uk-block-large">
        <h1 class="uk-contrast"><img src="/assets/logo@2x.png" width="250" height="91" alt="Podcast Profile Logo"></h1>
    </div>


</header>

<section class="uk-block uk-block-large site-block-home site-block-one uk-text-center">
    <h2 class="site-tagline">
        What are <strong>your</strong><br class="uk-hidden-small">
        favorite podcasts?
    </h2>

    <p class="uk-margin-large">
        <a class="uk-button uk-button-primary uk-button-large site-button-twitter" href="auth/twitter">Sign in with Twitter</a>
    </p>

</section>

<section class="uk-block uk-block-large site-block-home site-block-two">
    <div class="uk-grid uk-grid-width-medium-1-2">
        <div class="uk-text-center">
            SCREENSHOT
        </div>
        <p>
            Create a personal podcast profile. <br>
            Show others what you listen to.
        </p>
    </div>
</section>

<section class="uk-block uk-block-large site-block-home site-block-three uk-text-center">
    <h2>It’s easy.</h2>
    <p>
        Export your subscribed podcasts from any popular <br>
        podcast client. Simply upload that file. Done.
    </p>
</section>

<footer class="uk-block uk-block-large site-block-footer uk-text-center">
    <a href="https://twitter.com/podcastprofile">@podcastprofile</a>
    <a href="http://casualcoding.com">a casualcoding project</a>
</footer>
@stop
