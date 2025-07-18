@extends('layout.default')

@section('content')
    <h1>@lang('Despre noi')</h1>

    <div class="about-partners-logos">
        <a href="http://www.playbike.ro">
            <img src="{{ Vite::asset('resources/images/pb-logo.png') }}" alt="Playbike Logo" class="playbike-logo" target="_blank">
        </a>
        <a href="https://www.bike4rent.ro">
            <img src="{{ Vite::asset('resources/images/b4r-logo.png') }}" alt="Bike 4 Rent Logo" class="b4r-logo" target="_blank">
        </a>
        <a href="https://www.viatafaracric.ro/">
            <img src="{{ Vite::asset('resources/images/vfc-logo.png') }}" alt="Viata fara cric Logo" class="vfc-logo" target="_blank">
        </a>
        <a href="https://telefericgrandhotel.ro/">
            <img src="{{ Vite::asset('resources/images/ht-logo.png') }}" alt="Teleferic Grand Hotel Logo" class="ht-logo" target="_blank">
        </a>
    </div>

    <div class="about-text">
        <p>@lang('about_line_1')</p>

        <p>@lang('about_line_2')</p>

        <p>@lang('about_line_3')</p>

        <p>@lang('about_line_4')</p>
    </div>

@endsection
