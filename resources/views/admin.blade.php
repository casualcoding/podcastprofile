@extends('layouts.navbar')
@section('title', 'Admin')

@section('content')

<div class="uk-container uk-container-center uk-margin-large-top">
    <div id="admin">
        <!-- This is the tabbed navigation containing the toggling elements -->
        <ul class="uk-tab uk-margin-large-top" data-uk-tab="{connect:'#lists'}">
            <li><a href="">Users</a></li>
            <li><a href="">Podcasts</a></li>
            <li><a href="">Jobs</a></li>
            <li><a href="">Failed Jobs</a></li>
        </ul>

        <!-- This is the container of the content items -->
        <ul id="lists" class="uk-switcher uk-margin">
            <li>
                <div class="uk-overflow-container">
                    <table class="uk-table uk-table-striped">
                        <thead>
                            <tr>
                                <th>handle</th>
                                <th>name</th>
                                <th>url</th>
                                <th>twitter_id</th>
                                <th>role</th>
                                <th>created_at</th>
                                <th>updated_at</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($users as $user)
                            <tr>
                                <td><a href="/{{ $user->handle }}">{{ $user->handle }}</a></td>
                                <td>{{ $user->name }}</td>
                                <td class="uk-width-1-10 uk-text-truncate"><a href="/{{ $user->url }}">{{ $user->url }}</a></td>
                                <td>{{ $user->twitter_id }}</td>
                                <td>{{ $user->role }}</td>
                                <td>{{ $user->created_at }}</td>
                                <td>{{ $user->updated_at }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </li>
            <li>
                <div class="uk-overflow-container">
                    <table class="uk-table uk-table-striped">
                        <thead>
                            <tr>
                                <th>name</th>
                                <th>url</th>
                                <th>feed</th>
                                <th>coverimage</th>
                                <!-- <th>description</th> -->
                                <th>error</th>
                                <th>created_at</th>
                                <th>updated_at</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($podcasts as $podcast)
                            <tr>
                                @if ($podcast->name == null)
                                <td class="uk-text-danger">None</td>
                                @else
                                <td>{{ $podcast->name }}</td>
                                @endif
                                
                                @if ($podcast->url == null)
                                <td class="uk-text-danger">None</td>
                                @else
                                <td><a href="{{ $podcast->url }}">{{ $podcast->url }}</a></td>
                                @endif
                                
                                <td class="uk-width-1-10"><a href="{{ $podcast->feed }}">{{ $podcast->feed }}</a></td>
                                
                                <td><a href="/{{ $podcast->coverimage }}"><img src="{{ $podcast->coverimage }}" width="60" height="60"></a></td>
                                <!-- <td>{{ $podcast->description }}</td> -->
                                <td @if ($podcast->error != 0) class="uk-text-danger" @endif>{{ $podcast->error }}</td>
                                <td>{{ $podcast->created_at }}</td>
                                <td>{{ $podcast->updated_at }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </li>
            <li><pre>{{ var_dump($jobs) }}</pre></li>
            <li><pre>{{ var_dump($failed_jobs) }}</pre></li>
        </ul>
    </div>
</div>
@stop
