<ul class="uk-subnav uk-subnav-pill uk-subnav-line">

    <li @if ($active == 'podcasts') class="uk-active" @endif data-uk-dropdown>
        <a href="{{ URL::route('admin::getPodcasts') }}">{{ $counts['podcasts'] }} Podcasts <i class="uk-icon-caret-down"></i></a>
        <div class="uk-dropdown uk-dropdown-small">
            <ul class="uk-nav uk-nav-dropdown">
                <li><a href="{{ URL::route('admin::getPodcasts') }}">All Podcasts</a></li>
                <li><a href="{{ URL::route('admin::getRssErrorPodcasts') }}">{{ $counts['rss_error_podcasts'] }} RSS Error Podcasts</a></li>
            </ul>
        </div>
    </li>

    <li @if ($active == 'users') class="uk-active" @endif>
        <a href="{{ URL::route('admin::getUsers') }}">{{ $counts['users'] }} Users</a>
    </li>

    <li @if ($active == 'jobs') class="uk-active" @endif>
        <a href="{{ URL::route('admin::getJobs') }}">{{ $counts['jobs'] }} Jobs</a>
    </li>

    <li @if ($active == 'failed_jobs') class="uk-active" @endif>
        <a href="{{ URL::route('admin::getFailedJobs') }}">{{ $counts['failed_jobs'] }} Failed Jobs</a>
    </li>
</ul>
