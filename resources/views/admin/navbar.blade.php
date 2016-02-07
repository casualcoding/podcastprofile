<ul class="uk-subnav uk-subnav-pill uk-subnav-line">
    <li @if ($active == 'users') class="uk-active" @endif>
        <a href="{{ URL::route('admin::getUsers') }}">{{ $counts['users'] }} Users</a>
    </li>
    <li @if ($active == 'podcasts') class="uk-active" @endif>
        <a href="{{ URL::route('admin::getPodcasts') }}">{{ $counts['podcasts'] }} Podcasts</a>
    </li>
    <li @if ($active == 'jobs') class="uk-active" @endif>
        <a href="{{ URL::route('admin::getJobs') }}">{{ $counts['jobs'] }} Jobs</a>
    </li>
    <li @if ($active == 'failed_jobs') class="uk-active" @endif>
        <a href="{{ URL::route('admin::getFailedJobs') }}">{{ $counts['failed_jobs'] }} Failed Jobs</a>
    </li>
</ul>
