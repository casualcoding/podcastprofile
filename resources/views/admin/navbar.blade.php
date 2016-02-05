<ul class="uk-subnav">
    <li @if ($active == 'users') class="active" @endif>
        <a href="{{ URL::route('admin::getUsers') }}">{{ $counts['users'] }} Users</a>
    </li>
    <li @if ($active == 'podcasts') class="active" @endif>
        <a href="{{ URL::route('admin::getPodcasts') }}">{{ $counts['podcasts'] }} Podcasts</a>
    </li>
    <li @if ($active == 'jobs') class="active" @endif>
        <a href="{{ URL::route('admin::getJobs') }}">{{ $counts['jobs'] }} Jobs</a>
    </li>
    <li @if ($active == 'failed_jobs') class="active" @endif>
        <a href="{{ URL::route('admin::getFailedJobs') }}">{{ $counts['failed_jobs'] }} Failed Jobs</a>
    </li>
</ul>
