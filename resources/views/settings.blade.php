@extends('layouts.master')
@section('title', 'User Profile')

@section('content')

    <h1>Your Profile Settings</h1>

    <div class="uk-panel uk-panel-box">

        <h2>Upload XML file</h2>

        <form action="/upload" method="post">
            <input type="file" name="upload" value="">
            <input type="submit">
        </form>

    </div>

    <ul>

    </ul>

@stop
