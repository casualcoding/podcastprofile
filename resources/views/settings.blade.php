@extends('layouts.master')
@section('title', 'User Profile')

@section('content')

    <h1>Your Profile Settings</h1>

    <div class="uk-panel uk-panel-box">

        <h2>Upload XML file</h2>

        <form action="{{ URL::route('api::postProfile') }}" method="post" enctype="multipart/form-data">
            <input type="file" name="upload" value="">
            <input type="submit">
        </form>

    </div>

    <ul>

    </ul>

    <form action="{{ URL::route('api::postPodcastsByOpml') }}" method="post" enctype="multipart/form-data">
        {{ csrf_field() }}
        <input type="file" name="xml" value="">
        <input type="submit">
    </form>

@stop
