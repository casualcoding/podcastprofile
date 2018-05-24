@extends('layouts.navbar')
@section('title', 'Privacy Policy')

@section('content')

<div class="uk-container uk-container-center uk-margin-large-top">

    <article class="uk-width-medium-2-3 uk-align-center">

        <h2>Privacy and Cookies</h2>

        <p>We take your privacy very seriously and only store and process the minimum amount of data that we need to run Podcast Profile. All of your browser’s communication with our website is encrypted via SSL. In a nutshell, here is what we store about you:</p>

        <div class="uk-width-medium-2-3 uk-align-center" style="border-bottom: 1px solid #eee; padding-bottom: 40px">

            <ul class="">

                <li>
                    <p><strong>Server log files:</strong> On every web page request, our web server logs an anonymized form of your IP address, the referrer link, time and date of access and information about your OS and browser you use. This information allows us to have statistics of how frequently people visit podcastprofile and which browsers we should optimize the website for. This data is automatically deleted after 4 weeks.</p>
                </li>


                <li>
                    <p>We do not include any third party JavaScript or similar, be it analytics or anything else. <strong>We do not track you</strong> and don’t let others track you on our site.</p>
                </li>

                <li>
                    <p><strong>Cookies:</strong> When you visit our site, we store a cookie on your computer which is only used to make our login procedure work.</p>
                </li>

                <li>
                    <p><strong>Twitter login:</strong> For easy login, we use Twitter’s secure OAuth login procedure and therefore store your Twitter handle and a login token. We never have access to your Twitter password and cannot send tweets or messages from your account. Be aware that after the login, Twitter will know that you use our website. Twitter may also store additional cookies on your machine.</p>
                </li>

                <li>
                    <p>Additionally, we save the following information about you in our database: Your name, an avatar image and an optional website link (all initially fetched from your Twitter account). As soon as you add podcasts to your profile, we store which podcasts you have added. You can hide podcasts from your profile, but they are still stored in our database, in case you want to show them again at a later point.</p>
                </li>

                <li>
                    <p><strong>Account deletion:</strong> At every point in time, you may delete your Podcast Profile account yourself after you have logged in. Your account information and all connection to the podcasts you have listed will be removed from our database immediately.</p>
                </li>

                <li>
                    <p>If you want to learn what we have stored about you, you can request that information <a href="mailto:team@casualcoding.com">via email</a>.</p>
                </li>
            </ul>

        </div>


        @if (!Auth::user()->hasAcceptedPrivacyPolicy())
        <div class="uk-margin-large-top uk-margin-large-bottom">
            <p>As we are operating from Germany, the full <a href="/privacy" target="_blank">Privacy and Cookie policy</a> is written in German. Officially, that is the document that matters when you accept the checkbox below.</a></p>

            <form class="" action="{{ URL::route('api::postAcceptPrivacyPolicy') }}" method="post">
                {{ csrf_field() }}
                <label class="uk-text-bold"><input class="uk-checkbox uk-margin-bottom uk-margin-right" type="checkbox" id="checkbox">I understand and accept the Privacy and Cookie policy.</label>
                <button class="uk-button uk-button-large uk-button-primary uk-float-right" id="ok-button" disabled>OK</button>
            </form>

            <div class="uk-margin-large-top uk-text-righ uk-text-small">
                <a class="" data-uk-toggle="{target:'#delete-button-wrapper'}" href="javascript:return false;">I don't accept and want to delete my account instead.</a>
            </div>

            <div id="delete-button-wrapper" class="uk-hidden">
                <div class="uk-alert uk-alert-danger uk-margin-top">
                    <p>Do you really want to delete your account? The data we have stored about you will be removed immediately.</p>
                    <form class=" uk-margin-top" action="{{ URL::route('api::postDeleteAccount') }}" method="post">
                        {{ csrf_field() }}
                        <button class="uk-button uk-button-danger" onclick="return confirm('Are you sure?')"><i class="uk-icon-warning"></i> Delete Account</button>
                    </form>
                </div>
            </div>

        </div>
        <script type="text/javascript">
            var checker = document.getElementById('checkbox');
            var sendbtn = document.getElementById('ok-button');
            checker.onchange = function() {
                sendbtn.disabled = !this.checked;
            };
        </script>
        @endif

        </article>
</div>

@stop
