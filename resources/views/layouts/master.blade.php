<!DOCTYPE html>
<html lang="en-gb" dir="ltr">

    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>@yield('title') | Podcast Profile</title>
        <link rel="shortcut icon" href="/favicon.ico" type="image/x-icon">
        <link rel="apple-touch-icon-precomposed" href="images/apple-touch-icon.png">
        <link rel="stylesheet" href="/assets/dist/app.css" media="screen">
        <script src="/assets/dist/app.js"></script>

        @yield('head')

    </head>

    <body class="@yield('body-classes')">

            @yield('top')

            <div class="site-content">

                @yield('content')

            </div>

            <footer class="uk-block uk-block-large site-block-footer uk-text-center">
                <a href="https://twitter.com/podcastprofile">@podcastprofile</a>
                <br class="uk-visible-small">
                <a href="http://casualcoding.com">a casualcoding project</a>
                <br class="uk-visible-small">
                <a href="/impressum">Impressum</a>
                <br class="uk-visible-small">
                <a href="/privacy">Privacy Policy</a>
            </footer>

            <div class="cookie-notice">
                <div class="uk-text-contrast uk-text-center">
                    podcastprofile.com uses cookies to give you the best experience on our site. By using this site you accept our policy.
                    <br class="uk-hidden-large"><br class="uk-hidden-large">
                    <button class="js-cookie-accept uk-button site-button-cookie uk-margin-large-left">OK</button>
                    <a class="uk-margin-small-left uk-text-contrast" href="/impressum"> More</a>
                </div>
            </div>

            @yield('bottom')

    </body>
</html>
