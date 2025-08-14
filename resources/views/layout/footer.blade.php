<footer>
    <div class="footer-container">
        <div class="footer-partners-logos">
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

        <ul class="footer-contact-info">
            <li>
                <a href="tel:0734533091" title="@lang('Contactați-ne')">
                    <span class="material-symbols-outlined">phone_enabled</span>
                    0734.533.091
                </a>
            </li>
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
                <a href="https://www.facebook.com/profile.php?id=61579025440006" title="@lang('Facebook')" target="_blank">
                    @include('layout.svg.facebook-icon')
                    Facebook
                </a>
            </li>
            <li>
                <a href="https://www.instagram.com/rentabikebrasov/" title="@lang('Instagram')" target="_blank">
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
                <a href="https://www.tiktok.com/@rentabikebrasov.ro" title="@lang('TikTok')" target="_blank">
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
