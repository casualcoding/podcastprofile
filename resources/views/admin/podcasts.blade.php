@extends('layouts.navbar')
@section('title', 'Podcasts')

@section('content')

<div class="uk-container uk-container-center uk-margin-large-top">
    <div id="admin">
        @include('admin.navbar', ['active' => 'podcasts'])

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
                            <a class="uk-button uk-button-primary" href="{{ URL::route('admin::getEditPodcast', ['id' => $podcast->id]) }}">
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

        @include('layouts.pagination', ['paginator' => $podcasts])

    </div>
</div>
@stop
