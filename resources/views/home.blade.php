@extends('layouts.master')
@section('title', 'Show what podcasts you listen to')

@section('content')

        @if (!Auth::check())
        <p>
            You are not logged in!
        </p>
        @else 
        <p>
            You are logged in!
        </p>

        <div>
            Your name is {{ Auth::user()->name }}<br/>
            Your twitter handle is {{ Auth::user()->handle }}<br/>
            <img src="{{ Auth::user()->avatar }}" height="200" width="200" />
        </div>

        <div>
            <a href="auth/twitter/logout">logout</a>
        </div>
        @endif

@stop