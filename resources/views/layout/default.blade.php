@extends('layout.base')

@section('body')
    @include('layout.header')

    <div class="page-wrapper">
        @yield('content')
    </div>

    @include('layout.footer')

    @vite(['resources/js/main.js'])
@endsection
