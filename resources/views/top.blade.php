@extends('layouts.navbar')
@section('title', 'Top Podcasts')

@section('body-classes', '@parent site-profile')

@section('content')

    <div class="uk-container uk-container-center uk-margin-large-top">

        <div class="uk-width-medium-2-3 uk-align-center" data-uk-grid-margin>

            <h1>Top podcasts</h1>

            @forelse ($podcasts as $i => $podcast)
                <div class="uk-panel site-panel-podcast">
                    <div class="uk-grid" data-uk-grid-margin="">
                        <div class="uk-width-medium-1-3 uk-text-center">
                            <img src="{{ $podcast->coverimage }}" alt="Podcast Cover image" />
                        </div>
                        <div class="uk-width-medium-2-3 uk-flex uk-flex-middle">

                            <div>

                                <h2><span class="uk-text-muted">{{ $i+1 }}.</span> <a href="{{ $podcast->url }}">{{ $podcast->name }}</a></h2>
                                <p>
                                    {{ $podcast->description }}
                                </p>
                                <p>
                                    <a href="{{ $podcast->feed }}">Subscribe</a>
                                </p>
                            </div>

                        </div>

                    </div>
                </div>
            @empty
                    <div class="uk-article-lead">
                        <p class="uk-width-2-3 uk-text-center uk-align-center">
                            No podcasts added yet.
                        </p>
                    </div>
            @endforelse

        </div>
    </div>
@stop
