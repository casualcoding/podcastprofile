@extends('layouts.navbar')
@section('title', 'User Profile')

@section('content')

    <div class="uk-container uk-container-center uk-margin-top">


        <h1>Example Profile</h1>

        <p>
            IMAGE
        </p>

        <p>
            {{ $user->name }}
        </p>

        <p>
            Website
        </p>

        <p>
            List of podcasts...
        </p>

    </div>


@stop
