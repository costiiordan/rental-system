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

    <link rel="icon" href="/favicon.ico" sizes="any">
    <link rel="icon" href="/icon.svg" type="image/svg+xml">
    <link rel="apple-touch-icon" href="icon.png">

    <meta name="theme-color" content="#fafafa">

    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>

<body>
    @yield('body')
</body>
</html>
