@extends('layouts.master')

@section('top')

<div class="uk-navbar">
    <div class="uk-container uk-container-center">
        <a href="/" class="uk-navbar-brand">
            <img src="/assets/logo@1x.png" alt="Logo" />
        </a>

        <div class="uk-navbar-flip">
            <ul class="uk-navbar-nav">
                <li><a href="/settings">Settings</a></li>
                <li><a href="/logout">Logout</a></li>
            </ul>
        </div>
    </div>
</div>

@stop
