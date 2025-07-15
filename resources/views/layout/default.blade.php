@extends('layout.base')

@section('body')
    @include('layout.header')

    <main>
        <div class="page-wrapper" data-role="page-container" data-route="{{request()->route()->getName()}}">
            @yield('content')
        </div>
    </main>

    @include('layout.footer')

    @include('layout.cookie-consent')

    @vite(['resources/js/main.js'])
@endsection
