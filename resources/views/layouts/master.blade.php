<!DOCTYPE html>
<html lang="en-gb" dir="ltr">

    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>@yield('title') | Podcast Profile</title>
        <link rel="shortcut icon" href="images/favicon.ico" type="image/x-icon">
        <link rel="apple-touch-icon-precomposed" href="images/apple-touch-icon.png">
        <link rel="stylesheet" href="/assets/dist/app.css" media="screen">
        <script src="/assets/dist/app.js"></script>

        @yield('head')

    </head>

    <body>

            @yield('top')

            @yield('content')

    </body>
</html>
