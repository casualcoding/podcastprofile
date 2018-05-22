@extends('layouts.navbar')
@section('title', 'Privacy Policy')

@section('content')

<div class="uk-container uk-container-center uk-margin-large-top">

    <article class="uk-width-medium-2-3 uk-align-center">

        <h2>Privacy and Cookies</h2>

        <p>We take your privacy very seriously and only store and process the minimum amount of data that we need to run Podcast Profile. All of your browser’s communication with our website is encrypted via SSL. In a nutshell, here is what we store about you:</p>

        <p><strong>Server log files:</strong> On every web page request, our web server logs an anonymized form of your IP address, the referrer link, time and date of access and information about your OS and browser you use. This information allows us to have statistics of how frequently people visit podcastprofile and which browsers we should optimize the website for. This data is automatically deleted after 4 weeks.</p>

        <p>We do not include any third party JavaScript or similar, be it analytics or anything else. <strong>We do not track you</strong> and don’t let others track you on our site.</p>

        <p><strong>Cookies:</strong> When you visit our site, we store a cookie on your computer which is only used to make our login procedure work.</p>

        <p><strong>Twitter login:</strong> For easy login, we use Twitter’s secure OAuth login procedure and therefore store your Twitter handle and a login token. We never have access to your Twitter password and cannot send tweets or messages from your account. Be aware that after the login, Twitter will know that you use our website. Twitter may also store additional cookies on your machine.</p>

        <p>Additionally, we save the following information about you in our database: Your name, an avatar image and an optional website link (all initially fetched from your Twitter account). As soon as you add podcasts to your profile, we store which podcasts you have added. You can hide podcasts from your profile, but they are still stored in our database, in case you want to show them again at a later point.</p>

        <p><strong>Account deletion:</strong> At every point in time, you may delete your Podcast Profile account yourself after you have logged in. Your account information and all connection to the podcasts you have listed will be removed from our database immediately.</p>
        
        <p>If you want to learn what we have stored about you, you can request that information <a href="mailto:team@casualcoding.com">via email</a>.</p>

        <p>As we are operating from Germany, the full <a href="/privacy" target="_blank">Privacy and Cookie policy</a> is written in German. Officially, that is the document that matters when you accept the checkbox below.</a></p>

        @if (!Auth::user()->hasAcceptedPrivacyPolicy())
        <div class="uk-width-medium-3-4 uk-align-center uk-margin-large-top uk-margin-large-bottom">
            <form class="uk-text-center" action="{{ URL::route('api::postAcceptPrivacyPolicy') }}" method="post">
                {{ csrf_field() }}
                <label><input class="uk-checkbox uk-margin-bottom" type="checkbox">I understand and accept the Privacy and Cookie policy.</label><br>
                <button class="uk-button uk-button-primary">OK</button>
            </form>

            <form class="uk-text-center" action="{{ URL::route('api::postDeleteAccount') }}" method="post">
                {{ csrf_field() }}
                <button class="uk-button uk-button-danger"><i class="uk-icon-warning"></i> Delete Account</button>
            </form>
        </div>
        @endif
    
        </article>
</div>

@stop