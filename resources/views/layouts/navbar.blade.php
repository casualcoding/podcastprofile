@extends('layouts.master')

@section('body-classes', '@parent site-footer-margin')

@section('top')

<div class="uk-navbar">
    <div class="uk-container uk-container-center">
        <a href="#offcanvas" class="uk-navbar-toggle uk-visible-small" data-uk-offcanvas></a>

        <a href="/" class="uk-navbar-brand uk-hidden-small">
            <img src="/assets/logo-long@2x.png" width="165" height="25" alt="Podcast Profile Logo">
        </a>

        <a href="/" class="uk-navbar-brand uk-navbar-center uk-visible-small">
            <img src="/assets/logo-long@2x.png" width="165" height="25" alt="Podcast Profile Logo">
        </a>

        <div class="uk-navbar-flip uk-hidden-small">
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
</div>

@stop


@section('bottom')

<div id="offcanvas" class="uk-offcanvas">
    <div class="uk-offcanvas-bar">
        <ul class="uk-nav uk-nav-offcanvas" data-uk-nav>
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

@stop