@extends('layout.default')

@section('content')
    <h1>@lang('Contact')</h1>

    <div class="contact-page">
        <div class="contact-details">
            <div class="contact-item">
                <span class="material-symbols-outlined">phone_enabled</span>
                <div class="contact-item-info">
                    <span class="contact-label">@lang('Telefon'):</span>
                    <span class="contact-value">
                        0734.533.091
                    </span>
                </div>
            </div>
            <div class="contact-item">
                <span class="material-symbols-outlined">mail</span>
                <div class="contact-item-info">
                    <span class="contact-label">@lang('Email'):</span>
                    <span class="contact-value">
                    <a href="mailto:contact@rentabikebrasov.ro">contact@rentabikebrasov.ro</a>
                </span>
                </div>
            </div>
            <div class="contact-item">
                <span class="material-symbols-outlined">location_on</span>
                <div class="contact-item-info">
                    <span class="contact-label">@lang('Adresă'):</span>
                    <span class="contact-value">
                    @lang('Drumul Sulinar nr 1, Poiana Brasov, Romania')
                </span>
                </div>
            </div>
            <div class="contact-item">
                <span class="material-symbols-outlined">schedule</span>
                <div class="contact-item-info">
                    <span class="contact-label">@lang('Program de lucru'):</span>
                    <span class="contact-value">
                        <span class="wh-label">@lang('Luni')</span><span class="wh-value">@lang('09:00 - 17:00')</span><br>
                        <span class="wh-label">@lang('Marți')</span><span class="wh-value">@lang('ÎNCHIS')</span><br>
                        <span class="wh-label">@lang('Miercuri')</span><span class="wh-value">@lang('ÎNCHIS')</span><br>
                        <span class="wh-label">@lang('Joi')</span><span class="wh-value">@lang('09:00 - 17:00')</span><br>
                        <span class="wh-label">@lang('Vineri')</span><span class="wh-value">@lang('09:00 - 17:00')</span><br>
                        <span class="wh-label">@lang('Sâmbătă')</span><span class="wh-value">@lang('09:00 - 17:00')</span><br>
                        <span class="wh-label">@lang('Duminică')</span><span class="wh-value">@lang('09:00 - 17:00')</span>
                    </span>
                </div>
            </div>
        </div>
        <div class="contact-map">
            <iframe src="https://www.google.com/maps/embed?pb=!1m17!1m12!1m3!1d2792.054267965923!2d25.552331818984904!3d45.58945380135863!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m2!1m1!2zNDXCsDM1JzE5LjEiTiAyNcKwMzMnMDcuNCJF!5e0!3m2!1sen!2sro!4v1752665074966!5m2!1sen!2sro" width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
        </div>
    </div>
@endsection
