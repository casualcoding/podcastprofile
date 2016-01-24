@extends('layouts.navbar')
@section('title', 'Settings')

@section('head')
<meta name="csrf-token" content="{{ csrf_token() }}">
<script type="text/javascript">
    window.$user = <?php echo json_encode($user) ?>;
    window.$podcasts = <?php echo $user->podcastsPublic()->get()->toJson() ?>;
    window.$routes = {
        savePodcasts: "{{ URL::route('api::podcasts') }}"
    }
</script>
<script src="/assets/dist/settings.js"></script>
@stop

@section('content')

    <div class="uk-container uk-container-center uk-margin-top" id="settings">

        <div class="uk-panel uk-panel-box">

            <div class="uk-grid">
                <div class="uk-width-1-4 uk-text-center">
                    <p>
                        <img class="uk-border-circle" width="180" height="180" src="{{ $user->avatar }}" alt="">
                    </p>
                    <button type="button" class="uk-button uk-button-link">Upload new image</button>
                </div>

                <div class="uk-width-3-4">

                    <h2>Profile Details</h2>

                    <form class="uk-form uk-form-stacked" action="{{ URL::route('api::profile') }}" @submit.prevent="save($event)">
                        <div class="uk-form-row">
                            <label class="uk-form-label" for="name">Name</label>
                            <div class="uk-form-controls">
                                <input type="text" name="name" class="uk-form-large uk-width-1-1" placeholder="Your real name" v-model="user.name">
                            </div>
                        </div>

                        <div class="uk-form-row">
                            <label class="uk-form-label" for="url">Website</label>
                            <div class="uk-form-controls">
                                <input type="url" name="url" class="uk-form-large uk-width-1-1" placeholder="http://" v-model="user.url">
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

        <p class="uk-text-right">
            <button class="uk-button" @click="savePodcasts">Save podcasts</button>
        </p>

        <ul class="uk-sortable uk-list uk-list-space" v-el:list>
            <li v-for="podcast in podcasts" data-id="@{{ podcast.id }}">
                <div class="uk-panel uk-panel-box">
                    <div class="uk-sortable-handle uk-icon uk-icon-bars uk-margin-small-right"></div>
                    <strong>@{{ podcast.name }}</strong> | Position: @{{ podcast.position }}<br>
                    Say something about this podacst:<br>
                    <textarea name="name" rows="8" cols="40" v-model="podcast.comment"></textarea><br>
                    <input type="checkbox" v-model="podcast.visible"> Visible
                </div>
            </li>
        </ul>

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
