@extends('layout.default')

@section('content')
    <h1>@lang('Contact')</h1>

    <div class="contact-page">
        <div class="contact-details">
{{--            <div class="contact-row">--}}
{{--                <span class="contact-label">@lang('Telefon'):</span>--}}
{{--                <span class="contact-value">@lang('0723.123.456')</span>--}}
{{--            </div>--}}
            <div class="contact-row">
                <span class="contact-label">@lang('Email'):</span>
                <span class="contact-value">
                    <a href="mailto:contact@rentabikebrasov.ro">contact@rentabikebrasov.ro</a>
                </span>
            </div>
            <div class="contact-row">
                <span class="contact-label">@lang('Adresă'):</span>
                <span class="contact-value">
                    @lang('Drumul Sulinar nr 1, Poiana Brasov, Romanaia')
                </span>
            </div>
            <div class="contact-row">
                <span class="contact-label">@lang('Program de lucru'):</span>
                <span class="contact-value">
                    @lang('Luni: 09:00 - 17:00')<br>
                    @lang('Marți: ÎNCHIS')<br>
                    @lang('Miercuri: ÎNCHIS')<br>
                    @lang('Joi: 09:00 - 17:00')<br>
                    @lang('Vineri: 09:00 - 17:00')<br>
                    @lang('Sâmbătă: 09:00 - 17:00')<br>
                    @lang('Duminică: 09:00 - 17:00')
                </span>
            </div>
        </div>
        <div class="contact-map">
            <iframe src="https://www.google.com/maps/embed?pb=!1m17!1m12!1m3!1d2792.054267965923!2d25.552331818984904!3d45.58945380135863!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m2!1m1!2zNDXCsDM1JzE5LjEiTiAyNcKwMzMnMDcuNCJF!5e0!3m2!1sen!2sro!4v1752665074966!5m2!1sen!2sro" width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
        </div>
    </div>
@endsection
