@extends('layout.base')

@section('body')
    @include('layout.header')

    <main>
        <div class="page-wrapper" data-role="page-container" data-route="{{request()->route()->getName()}}">
            <nav class="main-nav">
                <ul>
                    <li>
                        <a href="{{ LaravelLocalization::localizeUrl(route('home')) }}" title="@lang('Home')">
                            @lang('Home')
                        </a>
                    </li>
                    <li>
                        <a href="{{ LaravelLocalization::localizeUrl(route('about')) }}" title="@lang('Despre noi')">
                            @lang('Despre noi')
                        </a>
                    </li>
                    <li>
                        <a href="{{ LaravelLocalization::localizeUrl(route('contact')) }}" title="@lang('Contact')">
                            @lang('Contact')
                        </a>
                    </li>
                </ul>
            </nav>

            @yield('content')
        </div>
    </main>

    @include('layout.footer')

    @vite(['resources/js/main.js'])
@endsection
