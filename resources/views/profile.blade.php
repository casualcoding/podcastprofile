@extends('layouts.navbar')
@section('title', 'User Profile')

@section('content')

    <div class="uk-container uk-container-center uk-margin-top">

        <div class="uk-grid">

            <div class="uk-width-medium-1-5">


                <div class="uk-panel uk-panel-box uk-text-center">
                    <img class="uk-border-circle" width="120" height="120" src="{{ $user->avatar }}" alt="">
                    <h3><strong>{{ $user->name }}</strong> listens to 23 podcasts</h3>

                    <p>
                        <a href="https://twitter.com/{{ $user->handle }}">{{ "@".$user->handle }}</a>
                    </p>

                    @if($user->website)
                    <p>
                        <a href="{{ $user->website }}">{{ $user->website }}</a>
                    </p>
                    @endif

                </div>

            </div>

            @foreach ($user->podcastsPublic as $podcast)

            <div class="uk-width-medium-4-5">
                <div class="uk-panel uk-panel-box uk-text-center">
                    <div class="uk-grid">
                        <div class="uk-width-medium-1-3">
                            <img src="{{ $podcast->coverimage }}" alt="" />
                        </div>
                        <div class="uk-width-medium-2-3">
                            {{ $podcast->pivot->description }}
                        </div>

                    </div>
                </div>

            </div>

            @endforeach
            
        </div>

    </div>


@stop
