@extends('layouts.master')
@section('title', 'Show which podcasts you listen to')

@section('content')

<header class="site-block-home site-block-header uk-text-center">

    <div class="site-navigation-absolute">

        <div class="uk-navbar-flip">
            <ul class="uk-navbar-nav">
                @if (Auth::check())
                    @if (Auth::user()->isAdmin())
                        <li><a href="{{ URL::route('admin::admin') }}">Admin</a></li>
                    @endif
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
        @if (Auth::check())
           <p>You can visit your <a href="/{{ Auth::user()->handle }}">profile</a> or edit the <a href="{{ URL::route('settings') }}">settings</a>.</p>
        @else
            <a class="uk-button uk-button-primary uk-button-large site-button-twitter" href="auth/twitter">Sign in with Twitter</a>
        @endif
    </p>

</section>

<section class="uk-block uk-block-large site-block-home site-block-two">
    <div class="uk-grid uk-grid-width-medium-1-2">
        <div class="uk-text-center">
            <img src="/assets/screenshot@2x.png" width="500" height="495" alt="Screenshot">
        </div>
        <div class="uk-flex uk-flex-middle">
            <div class="site-padding">
                <h2>Your profile.</h2>
                <p>
                    Create a personal podcast profile. <br>
                    Show others what you listen to.
                </p>
                <h2 class="uk-margin-large-top">Easy import.</h2>
                <p>
                    Export your subscribed podcasts from any popular <br>
                    podcast client. Simply upload that file. Done.
                </p>
            </div>
        </div>
    </div>
</section>

@stop
