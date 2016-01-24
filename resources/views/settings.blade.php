@extends('layouts.navbar')
@section('title', 'Settings')

@section('content')

    <div class="uk-container uk-container-center uk-margin-top">

        <h1>Your Profile Settings</h1>

        <div class="uk-panel uk-panel-box">

            <h2>Upload something. Doesn't do anything. Joke is on you.</h2>

            <form action="{{ URL::route('api::postProfile') }}" method="post" enctype="multipart/form-data" class="uk-form">
                <input type="file" name="upload" value="">
                <input type="submit">
            </form>

        </div>

        <hr class="uk-grid-divider">

        <div class="uk-panel uk-panel-box">
            <form action="{{ URL::route('api::postPodcastsByOpml') }}" method="post" enctype="multipart/form-data"  class="uk-form">
                <h2>Upload OPML</h2>

                {{ csrf_field() }}
                <input type="file" name="xml" value="">
                <button  class="uk-button uk-button-primary">Upload</button>
            </form>
        </div>

    </div>


@stop
