<!doctype html>
<html lang="{{ app()->getLocale() }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>{{trans('website.title')}}</title>
        @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
            @vite(['resources/css/main.css'])
        @endif
        <meta name="description" content="{{trans('website.description')}}">

        <meta property="og:title" content="{{trans('website.title')}}">
        <meta property="og:type" content="website">
        <meta property="og:url" content="{{config('app.url')}}">
        <meta property="og:image" content="">
        <meta property="og:image:alt" content="">

        <link rel="icon" href="/favicon.ico" sizes="any">
        <link rel="icon" href="/icon.svg" type="image/svg+xml">
        <link rel="apple-touch-icon" href="icon.png">

        <meta name="theme-color" content="#fafafa">

        <meta name="csrf-token" content="{{ csrf_token() }}">
    </head>

    <body>
        <header>
            <h1>{{trans('website.title')}}</h1>
        </header>

        @yield('content')

        @vite(['resources/js/main.js'])
    </body>
</html>
