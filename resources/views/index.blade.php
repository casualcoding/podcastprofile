@extends('layouts.master')
@section('title', 'Show what podcasts you listen to')

@section('content')

<div class="uk-container uk-container-center uk-margin-top uk-margin-large-bottom">

    <div class="uk-grid" data-uk-grid-margin>
        <div class="uk-width-medium-1-1 uk-position-relative">

            @if (Auth::check())
                <div class="uk-position-top-right uk-margin-right uk-margin-top">
                    <a href="auth/twitter/logout">logout</a>
                </div>
            @endif

            <div class="uk-vertical-align uk-text-center" style="background: url('data:image/svg+xml;base64,PD94bWwgdmVyc2lvbj0iMS4wIiBlbmNvZGluZz0idXRmLTgiPz4NCjwhLS0gR2VuZXJhdG9yOiBBZG9iZSBJbGx1c3RyYXRvciAxNi4wLjQsIFNWRyBFeHBvcnQgUGx1Zy1JbiAuIFNWRyBWZXJzaW9uOiA2LjAwIEJ1aWxkIDApICAtLT4NCjwhRE9DVFlQRSBzdmcgUFVCTElDICItLy9XM0MvL0RURCBTVkcgMS4xLy9FTiIgImh0dHA6Ly93d3cudzMub3JnL0dyYXBoaWNzL1NWRy8xLjEvRFREL3N2ZzExLmR0ZCI+DQo8c3ZnIHZlcnNpb249IjEuMSIgaWQ9IkViZW5lXzEiIHhtbG5zPSJodHRwOi8vd3d3LnczLm9yZy8yMDAwL3N2ZyIgeG1sbnM6eGxpbms9Imh0dHA6Ly93d3cudzMub3JnLzE5OTkveGxpbmsiIHg9IjBweCIgeT0iMHB4Ig0KCSB3aWR0aD0iMTEzMHB4IiBoZWlnaHQ9IjQ1MHB4IiB2aWV3Qm94PSIwIDAgMTEzMCA0NTAiIGVuYWJsZS1iYWNrZ3JvdW5kPSJuZXcgMCAwIDExMzAgNDUwIiB4bWw6c3BhY2U9InByZXNlcnZlIj4NCjxyZWN0IGZpbGw9IiNGNUY1RjUiIHdpZHRoPSIxMTMwIiBoZWlnaHQ9IjQ1MCIvPg0KPC9zdmc+DQo=') 50% 0 no-repeat; height: 450px;">
                <div class="uk-vertical-align-middle uk-width-1-2">
                    <h1 class="uk-heading-large">What are <strong>your</strong><br> favorite podcasts?</h1>
                    <p class="uk-text-large">Create a personal podcast profile. Show others what you listen to.</p>
                    @if (!Auth::check())
                        <p>
                            <a class="uk-button uk-button-primary uk-button-large" href="auth/twitter">Sign in with Twitter</a>
                        </p>
                    @else
                        <p>
                            <a class="" href="#">
                                <img class="uk-thumbnail" src="{{ Auth::user()->avatar }}" height="150" width="150" />
                                <div class="uk-thumbnail-caption">{{ Auth::user()->handle }}</div>
                            </a>
                        </p>
                    @endif
                </div>
            </div>

        </div>
    </div>

    <div class="uk-width-2-3 uk-align-center uk-margin-large">

        <div class="uk-grid" data-uk-grid-margin>
            <div class="uk-width-medium-1-2">
                <div class="uk-grid">
                    <div class="uk-width-1-6">
                        <i class="uk-icon-users uk-icon-large uk-text-primary"></i>
                    </div>
                    <div class="uk-width-5-6">
                        <h2 class="uk-h3">Your profile</h2>
                        <p>A personal profile. Send to your friends, send to your enemies. Let everyone know about your favorite podcasts.</p>
                    </div>
                </div>
            </div>

            <div class="uk-width-medium-1-2">
                <div class="uk-grid">
                    <div class="uk-width-1-6">
                        <i class="uk-icon-upload uk-icon-large uk-text-primary"></i>
                    </div>
                    <div class="uk-width-5-6">
                        <h2 class="uk-h3">Upload from your client</h2>
                        <p>All popular podcasts clients can export a file with your subscribed podcasts. Just upload that file. Done.</p>
                    </div>
                </div>
            </div>


        </div>

    </div>

    <hr class="uk-grid-divider">
    @if (!Auth::check())
        <div class="uk-grid" data-uk-grid-margin>
            <div class="uk-width-medium-1-1">
                <div class="uk-panel uk-panel-box uk-text-center">
                    <p>Which podcasts do <strong>you</strong> listen to? Create your podcast profile now. <a class="uk-button uk-button-primary uk-margin-left" href="auth/twitter">Sign in with Twitter</a></p>
                </div>
            </div>
        </div>
    @endif

</div>

@stop
