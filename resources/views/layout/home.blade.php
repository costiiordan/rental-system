@extends('layout.base')

@section('body')
    @include('layout.header')

    @yield('content')

    @include('layout.footer')

    @include('layout.cookie-consent')

    <x-js-data/>
    @vite(['resources/js/main.js'])
@endsection
