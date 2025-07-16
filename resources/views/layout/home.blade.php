@extends('layout.base')

@section('body')
    @include('layout.header')

    @yield('content')

    @include('layout.footer')

    @include('layout.cookie-consent')

    @vite(['resources/js/main.js'])
@endsection
