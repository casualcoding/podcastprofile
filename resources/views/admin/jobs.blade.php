@extends('layouts.navbar')
@section('title', 'Jobs')

@section('content')

<div class="uk-container uk-container-center uk-margin-large-top">
    <div id="admin">
        @include('admin.navbar', ['active' => 'jobs'])

        <div class="uk-overflow-container">
            @if (count($jobs) > 0)
            <table class="uk-table uk-table-striped" style="table-layout: fixed;">
                <thead>
                    <tr>
                        <th class="uk-width-5-10">payload</th>
                        <th class="uk-width-1-10">attempts</th>
                        <th class="uk-width-1-10">reserved</th>
                        <th class="uk-width-1-10">available</th>
                        <th class="uk-width-1-10">created</th>
                        <th class="uk-width-1-10"></th>
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
                        <td>
                            <form method="post" action="{{ URL::route('api::admin::postDeleteJob', ['id' => $job->id]) }}">
                                {{ csrf_field() }}
                                <button class="uk-button uk-button-danger"><i class="uk-icon-trash-o"></i> Stop</button>
                            </form>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            @endif
        </div>

        @include('layouts.pagination', ['paginator' => $jobs])

    </div>
</div>
@stop
