<!doctype html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@lang('Închiriază biciclete în Poiana Brașov')</title>
    @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
        @vite(['resources/css/main.css'])
    @endif
    <x-google-icon-import />
    <meta name="description" content="@lang('Închiriază biciclete în Poiana Brașov la cele mai bune prețuri. Descoperă frumusețea naturii pe două roți!')">

    <meta property="og:title" content="@lang('Închiriază biciclete în Poiana Brașov')">
    <meta property="og:type" content="website">
    <meta property="og:url" content="{{LaravelLocalization::localizeUrl(config('app.url'))}}">
    <meta property="og:image" content="">
    <meta property="og:image:alt" content="">

    <link rel="icon" type="image/png" href="/favicon-96x96.png" sizes="96x96" />
    <link rel="icon" type="image/svg+xml" href="/favicon.svg" />
    <link rel="shortcut icon" href="/favicon.ico" />
    <link rel="apple-touch-icon" sizes="180x180" href="/apple-touch-icon.png" />
    <meta name="apple-mobile-web-app-title" content="MyWebSite" />
    <link rel="manifest" href="/site.webmanifest" />

    <meta name="theme-color" content="#fafafa">

    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>

<body>
    @yield('body')
</body>
</html>
