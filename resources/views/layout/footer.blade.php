<footer>
    <div class="footer-container">
        <ul class="footer-contact-info">
{{--            <li>--}}
{{--                <a href="tel:0723123456" title="@lang('Contactați-ne')">--}}
{{--                    <span class="material-symbols-outlined">phone_enabled</span>--}}
{{--                    0723.123.456--}}
{{--                </a>--}}
{{--            </li>--}}
            <li>
                <a href="mailto:contact@rentabikebrasov.ro">
                    <span class="material-symbols-outlined">mail</span>
                    contact@rentabikebrasov.ro
                </a>
            </li>
            <li>
                <a href="" >
                    <span class="material-symbols-outlined">location_on</span>
                    Drumul Sulinar nr 1, Poiana Brașov
                </a>
            </li>
        </ul>
        <ul class="footer-social-media">
            <li>
                <a href="https://www.facebook.com/PlayBikeGo" title="@lang('Facebook')" target="_blank">
                    @include('layout.svg.facebook-icon')
                    Facebook
                </a>
            </li>
            <li>
                <a href="https://www.instagram.com/playbike.ro" title="@lang('Instagram')" target="_blank">
                    @include('layout.svg.instagram-icon')
                    Instagram
                </a>
            </li>
            <li>
                <a href="https://www.youtube.com/channel/UCbk602a0YNap-HZITm6LzjQ" title="@lang('Youtube')" target="_blank">
                    @include('layout.svg.youtube-icon')
                    Youtube
                </a>
            </li>
            <li>
                <a href="https://www.tiktok.com/@playbike.ro" title="@lang('TikTok')" target="_blank">
                    @include('layout.svg.ticktock-icon')
                    TikTok
                </a>
            </li>
        </ul>
        <ul class="footer-links">
            <li>
                <a href="{{LaravelLocalization::localizeUrl(route('cookie-policy'))}}" title="@lang('Politica de utilizare a cookie-urilor')">@lang('Politica de utilizare a cookie-urilor')</a>
            </li>
            <li>
                <a href="{{LaravelLocalization::localizeUrl(route('about'))}}" title="@lang('Despre noi')">@lang('Despre noi')</a>
            </li>
            <li>
                <a href="{{LaravelLocalization::localizeUrl(route('contact'))}}" title="@lang('Contact')">@lang('Contact')</a>
            </li>
        </ul>
        <p class="footer-copyright">
            <span>
                &copy; {{ date('Y') }}
                <a href="{{LaravelLocalization::localizeUrl(route('home'))}}" title="@lang('Închiriază biciclete în Poiana Brașov')">@lang('Rent a bike Brașov.')</a>
                @lang('Toate drepturile rezervate.')
            </span>
            <span>
                Made with <span class="material-symbols-outlined">favorite</span> by
                <a href="https://www.linkedin.com/in/constantiniordan/" target="_blank">Constantin Iordan</a>
            </span>
        </p>
    </div>
</footer>
