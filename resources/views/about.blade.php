@extends('layout.default')

@section('content')
    <h1>@lang('Despre noi')</h1>

    <div class="about-image">
        <img src="{{ asset('images/about/about-1.avif') }}" alt="@lang('Despre noi')">
    </div>

    <div class="about-text">
        <p>@lang('about_line_1')</p>

        <p>@lang('about_line_2')</p>

        <p>@lang('about_line_3')</p>

        <p>@lang('about_line_4')</p>
    </div>
@endsection
