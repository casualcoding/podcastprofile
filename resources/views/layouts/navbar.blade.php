@extends('layouts.master')

@section('body-classes', '@parent site-footer-margin')

@section('top')

<div class="uk-navbar">
    <div class="uk-container uk-container-center">
        <a href="/" class="uk-navbar-brand">
            <img src="/assets/logo-long@2x.png" width="165" height="25" alt="Podcast Profile Logo">
        </a>

        <div class="uk-navbar-flip">
            <ul class="uk-navbar-nav">
                    {{-- <li><a href="/{{ URL::route('top') }}">Top Podcasts</a></li> --}}
                @if (Auth::check())
                    @if (Auth::user()->isAdmin())
                        <li><a href="{{ URL::route('admin') }}">Admin</a></li>
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
