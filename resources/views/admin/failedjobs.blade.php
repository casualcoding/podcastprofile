@extends('layouts.navbar')
@section('title', 'Jobs')

@section('content')

<div class="uk-container uk-container-center uk-margin-large-top">
    <div id="admin">
        @include('admin.navbar', ['active' => 'failed_jobs'])

        @foreach ($failed_jobs as $job)
        <pre>{{ var_dump($job) }}</pre>
        @endforeach

        @include('layouts.pagination', ['paginator' => $failed_jobs])

    </div>
</div>
@stop
