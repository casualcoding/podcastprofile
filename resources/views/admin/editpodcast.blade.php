@extends('layouts.navbar')
@section('title', 'Edit Podcast')

@section('content')

<div class="uk-container uk-container-center uk-margin-large-top">
    <div id="admin">
        @include('admin.navbar', ['active' => 'podcasts'])

        <div class="uk-panel uk-panel-box">
            <h2>Edit Podcast</h2>
            <p>Enter any image URL. The image will be downloaded, cropped and saved to <code>/images</code> before it is stored in the database.</p>

            <form class="uk-form uk-form-horizontal" method="post" action="{{ URL::route('api::admin::postEditPodcast', ['id' => $podcast->id]) }}">
                {{ csrf_field() }}


                <div class="uk-form-row">
                    <label class="uk-form-label">Feed URL</label>
                    <div class="uk-form-controls">
                        <input type="text" class="uk-form-large uk-width-1-1" disabled value="{{ $podcast->feed }}">
                    </div>
                </div>

                <div class="uk-form-row">
                    <label class="uk-form-label" for="name">Name</label>
                    <div class="uk-form-controls">
                        <input type="text" class="uk-form-large uk-width-1-1" name="name" value="{{ $podcast->name }}">
                    </div>
                </div>

                <div class="uk-form-row">
                    <label class="uk-form-label" for="coverimage">Image URL</label>
                    <div class="uk-form-controls">
                        <input type="text" class="uk-form-large uk-width-1-1" name="coverimage" value="{{ $podcast->coverimage }}">
                    </div>
                </div>

                <div class="uk-form-row">
                    <label class="uk-form-label" for="url">Web URL</label>
                    <div class="uk-form-controls">
                        <input type="text" class="uk-form-large uk-width-1-1" name="url" value="{{ $podcast->url }}">
                    </div>
                </div>

                <div class="uk-form-row">
                    <label class="uk-form-label" for="error">Error</label>
                    <div class="uk-form-controls">
                        <input type="text" class="uk-form-large uk-width-1-1" name="error" value="{{ $podcast->error }}">
                    </div>
                </div>

                <div class="uk-form-row">
                    <div class="uk-form-controls uk-align-right">
                        <button class="uk-button uk-button-primary uk-button-large">Save</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@stop
