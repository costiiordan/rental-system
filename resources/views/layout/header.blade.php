<header class="header">
    <div class="top-bar-container">
        <div class="top-bar">
            <div class="social-media-links">
                <span class="social-media-text">@lang('Social media:')</span>
                <a href="https://www.facebook.com/PlayBikeGo" class="social-media-icon" title="@lang('Facebook')" target="_blank">
                    @include('layout.svg.facebook-icon')
                </a>
                <a href="https://www.instagram.com/playbike.ro" title="@lang('Instagram')" class="social-media-icon" target="_blank">
                    @include('layout.svg.instagram-icon')
                </a>
                <a href="https://www.youtube.com/channel/UCbk602a0YNap-HZITm6LzjQ" title="@lang('Youtube')" class="social-media-icon" target="_blank">
                    @include('layout.svg.youtube-icon')
                </a>
                <a href="https://www.tiktok.com/@playbike.ro" title="@lang('TikTok')" class="social-media-icon" target="_blank">
                    @include('layout.svg.ticktock-icon')
                </a>
            </div>
            <div class="contact-info">
{{--                <a href="tel:0723123456" class="contact-phone" title="@lang('Contactați-ne')">--}}
{{--                    <span class="material-symbols-outlined">phone_enabled</span>--}}
{{--                    0723.123.456--}}
{{--                </a>--}}
                <a href="mailto:contact@rentabikebrasov.ro" class="contact-email">
                    <span class="material-symbols-outlined">mail</span>
                    contact@rentabikebrasov.ro
                </a>
                <span class="contact-location">
                    <span class="material-symbols-outlined">location_on</span>
                    Drumul Sulinar nr 1, Poiana Brașov
                </span>
            </div>
        </div>
    </div>
    <div class="header-container">
        <div>
            <div class="header-content">
                <button class="header-menu-button" data-action="toggle-mobile-menu">
                    <span class="material-symbols-outlined">menu</span>
                </button>
                <a href="{{config('app.url')}}" class="header-logo-link" title="@lang('Rent a bike Brașov')">
                    <img src="{{Vite::asset('resources/images/rent-bike-brasov-logo.svg')}}" alt="Rent a bike Brasov" class="header-logo">
                </a>
            </div>
            <div class="header-content">
                <div class="header-menu">
                    <ul>
                        <li>
                            <a href="{{route('home')}}" title="@lang('Home')"
                               class="{{ request()->routeIs(['home', 'category']) ? 'is-active' : '' }}">
                                @lang('Home')
                            </a>
                        </li>
                        <li>
                            <a href="{{route('about')}}" title="@lang('Despre noi')"
                               class="{{ request()->routeIs('about') ? 'is-active' : '' }}">
                                @lang('Despre noi')
                            </a>
                        </li>
                        <li>
                            <a href="{{route('contact')}}" title="@lang('Contact')"
                               class="{{ request()->routeIs('contact') ? 'is-active' : '' }}">
                                @lang('Contact')
                            </a>
                        </li>
                    </ul>
                </div>
                <button class="cart-preview-button" data-action="toggle-cart-preview">
                    <span class="material-symbols-outlined">shopping_cart</span>
                    <span class="cart-preview-count" data-role="cart-items-count"></span>
                </button>
                <button class="language-switcher-button" data-action="toggle-language-switcher">
                    <span class="material-symbols-outlined">language</span>
                    <span class="current-language-flag">
                        @if (LaravelLocalization::getCurrentLocale() === 'ro')
                            @include('layout.svg.ro-flag')
                        @endif
                        @if (LaravelLocalization::getCurrentLocale() === 'en')
                            @include('layout.svg.en-flag')
                        @endif
                    </span>
                </button>
                <div class="language-switcher-dropdown" data-role="language-switcher-dropdown">
                    <ul>
                        @foreach(LaravelLocalization::getSupportedLocales() as $localeCode => $properties)
                            <li>
                                <a rel="alternate" hreflang="{{ $localeCode }}"
                                   href="{{ LaravelLocalization::getLocalizedURL($localeCode, null, [], true) }}">
                                    @if($properties['regional'] === 'en_GB')
                                        @include('layout.svg.en-flag')
                                    @endif
                                    @if($properties['regional'] === 'ro_RO')
                                        @include('layout.svg.ro-flag')
                                    @endif
                                    {{$properties['native']}}
                                </a>
                            </li>
                        @endforeach
                    </ul>
                </div>
                <x-cart-preview />
            </div>
        </div>
    </div>
</header>

<div class="navigation-menu" data-role="mobile-menu">
    <ul>
        <li class="close-menu-item">
            <a href="#" data-action="close-mobile-menu">
                <span class="material-symbols-outlined">chevron_backward</span>
                @lang('Închide meniul')
            </a>
        </li>
        <li>
            <a href="{{route('home')}}" title="@lang('Home')">
                @lang('Home')
            </a>
        </li>
        <li>
            <a href="{{route('about')}}" title="@lang('Despre noi')">
                @lang('Despre noi')
            </a>
        </li>
        <li>
            <a href="{{route('contact')}}" title="@lang('Contact')">
                @lang('Contact')
            </a>
        </li>
    </ul>
</div>

