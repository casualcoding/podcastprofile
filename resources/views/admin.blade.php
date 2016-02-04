@extends('layouts.navbar')
@section('title', 'Admin')

@section('content')

<div class="uk-container uk-container-center uk-margin-large-top">
    <div id="admin">
        <!-- This is the tabbed navigation containing the toggling elements -->
        <ul class="uk-tab uk-margin-large-top" data-uk-tab="{connect:'#lists'}">
            <li><a href="">{{ count($users) }} users</a></li>
            <li><a href="">{{ count($podcasts) }} podcasts</a></li>
            <li><a href="">{{ count($jobs) }} jobs</a></li>
            <li><a href="">{{ count($failed_jobs) }} failed Jobs</a></li>
        </ul>

        <!-- This is the container of the content items -->
        <ul id="lists" class="uk-switcher uk-margin">
            <li>
                <div class="uk-overflow-container">
                    <table class="uk-table uk-table-striped" style="table-layout: fixed;">
                        <thead>
                            <tr>
                                <th class="uk-width-2-10">handle</th>
                                <th class="uk-width-2-10">name</th>
                                <th class="uk-width-2-10">url</th>
                                <th class="uk-width-1-10">twitter id</th>
                                <th class="uk-width-1-10 uk-text-right">role</th>
                                <th class="uk-width-1-10">created</th>
                                <th class="uk-width-1-10">updated</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($users as $user)
                            <tr>
                                <td><a href="/{{ $user->handle }}">{{ $user->handle }}</a></td>
                                <td>{{ $user->name }}</td>
                                <td><div class="uk-width-1-1 uk-text-truncate"><a href="{{ $user->url }}">{{ $user->url }}</a></div></td>
                                <td>{{ $user->twitter_id }}</td>
                                <td class="uk-text-right">{{ $user->role }}</td>
                                <td class="uk-text-small uk-text-muted">{{ $user->created_at }}</td>
                                <td class="uk-text-small uk-text-muted">{{ $user->updated_at }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </li>
            <li>
                <div class="uk-overflow-container">

                    <table class="uk-table uk-width-1-1 uk-table-striped" style="table-layout: fixed;">
                        <thead>
                            <tr>
                                <th class="uk-width-2-10">name</th>
                                <th class="uk-width-3-10">url / feed</th>
                                <th class="uk-width-1-10">cover</th>
                                <!-- <th>description</th> -->
                                <th class="uk-width-1-10">error</th>
                                <th class="uk-width-1-10">created</th>
                                <th class="uk-width-1-10">updated</th>
                                <th class="uk-width-1-10"></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($podcasts as $podcast)
                            <tr>
                                @if ($podcast->name == null)
                                <td class="uk-text-danger">None</td>
                                @else
                                <td >{{ $podcast->name }}</td>
                                @endif

                                <td>
                                    <div class="uk-width-1-1 uk-text-truncate">
                                        <!-- url -->
                                        @if ($podcast->url == null)
                                        <span class="uk-text-danger">None</span>
                                        @else
                                        <i class="uk-icon-link"></i> <a href="{{ $podcast->url }}">{{ $podcast->url }}</a>
                                        @endif

                                        <!-- feed -->
                                        <br><i class="uk-icon-rss"></i> <a href="{{ $podcast->feed }}">{{ $podcast->feed }}</a>
                                    </div>
                                </td>
                                <td><a href="{{ $podcast->coverimage }}"><img src="{{ $podcast->coverimage }}" width="60" height="60"></a></td>
                                <!-- <td>{{ $podcast->description }}</td> -->
                                <td  @if ($podcast->error != 0) class="uk-text-danger" @endif>{{ $podcast->error }}</td>
                                <td class="uk-text-small uk-text-muted">{{ $podcast->created_at }}</td>
                                <td class="uk-text-small uk-text-muted">{{ $podcast->updated_at }}</td>
                                <td>
                                    <a class="uk-button uk-button-primary" href="{{ URL::route('getEditPodcast', ['id' => $podcast->id]) }}">
                                        <i class="uk-icon-wrench"></i> Edit
                                    </a>
                                    @if ($podcast->edited_manually)
                                    <br><span class="uk-text-small uk-text-muted"><i class="uk-icon-lock"></i> Edited manually</span>
                                    @endif
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </li>
            <li>
                <div class="uk-overflow-container">
                    @if (count($jobs) > 0)
                    <table class="uk-table uk-table-striped" style="table-layout: fixed;">
                        <thead>
                            <tr>
                                <th class="uk-width-6-10">payload</th>
                                <th class="uk-width-1-10">attempts</th>
                                <th class="uk-width-1-10">reserved</th>
                                <th class="uk-width-1-10">available</th>
                                <th class="uk-width-1-10">created</th>
                                <!--<th class="uk-width-1-10"></th>-->
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($jobs as $job)
                            <tr>
                                <td><pre style="background:none;">{{ $job->payload }}</pre></td>
                                <td>{{ $job->attempts }}</td>
                                <td class="uk-text-small uk-text-muted">{{ $job->reserved_at }}</td>
                                <td class="uk-text-small uk-text-muted">{{ $job->created_at }}</td>
                                <td class="uk-text-small uk-text-muted">{{ $job->available_at }}</td>
                                {{-- <td><a class="uk-button uk-button-danger" href="{ URL::route('api::postDeleteJob', ['id' => $job->id]) }}"><i class="uk-icon-trash-o"></i> Stop</a> --}
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    @else
                    <p>There are no jobs.</p>
                    @endif
                </div>
            </li>
            <li><pre>{{ var_dump($failed_jobs) }}</pre></li>
        </ul>
    </div>
</div>
@stop
