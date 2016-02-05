@extends('layouts.navbar')
@section('title', 'Users')

@section('content')

<div class="uk-container uk-container-center uk-margin-large-top">
    <div id="admin">
        @include('admin.navbar', ['active' => 'users'])

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

        {{ $users->links() }}

    </div>
</div>
@stop
