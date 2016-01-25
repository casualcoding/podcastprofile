@extends('layouts.navbar')
@section('title', $user->name)

@section('body-classes', 'site-profile')

@section('content')

    <div class="uk-container uk-container-center uk-margin-large-top">

        <div class="uk-grid" data-uk-grid-margin>

            <div class="uk-width-medium-1-5">

                <div class="uk-panel site-panel-profile uk-text-center" data-uk-sticky="{top: 15, media: 768}">
                    <img class="uk-border-circle" width="120" height="120" src="{{ $user->avatar }}" alt="">
                    <h3><strong>{{ $user->name }}</strong> listens to {{ $user->podcastsPublic->count() }} podcasts</h3>

                    <p>
                        <a href="https://twitter.com/{{ $user->handle }}">{{ "@".$user->handle }}</a>
                    </p>

                    @if($user->url)
                    <p>
                        <a href="{{ $user->url }}">Website</a>
                    </p>
                    @endif

                </div>
            </div>

            <div class="uk-width-medium-4-5">

                @forelse ($user->podcastsPublic as $podcast)
                <div class="uk-panel site-panel-podcast">
                    <div class="uk-grid" data-uk-grid-margin>
                        <div class="uk-width-medium-1-3 uk-text-center">
                            <img src="{{ $podcast->coverimage }}" alt="Podcast Cover image" />
                        </div>
                        <div class="uk-width-medium-2-3 uk-flex uk-flex-middle">

                            <div>
                                <h2><a href="{{ $podcast->url }}" class="uk-link-reset">{{ $podcast->name }}</a></h2>
                                <p class="uk-article-lead">
                                    {{ $podcast->pivot->description }}
                                </p>
                                <p>
                                    <a href="{{ $podcast->feed }}" class="uk-link-reset">Subscribe</a>
                                </p>
                            </div>

                        </div>

                    </div>
                </div>
                @empty
                    <div class="uk-article-lead">
                        <p class="uk-width-2-3 uk-text-center uk-align-center">
                            {{ $user->name }} has not added any podcasts to their profile yet.
                        </p>
                    </div>
                @endforelse

            </div>
        </div>
    </div>
@stop
