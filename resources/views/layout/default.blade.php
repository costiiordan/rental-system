@extends('layout.base')

@section('body')
    @include('layout.header')

    <main>
        <div class="page-wrapper">
            @yield('content')
        </div>
    </main>

    @include('layout.footer')

    @include('layout.cookie-consent')

    <x-js-data/>
    @vite(['resources/js/main.js'])
@endsection
