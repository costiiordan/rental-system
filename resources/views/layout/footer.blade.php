<footer>
    <div class="footer-container">
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
            &copy; {{ date('Y') }}
            <a href="{{LaravelLocalization::localizeUrl(route('home'))}}" title="@lang('Închiriază biciclete în Poiana Brașov')">@lang('Rent a bike Brașov.')</a>
            @lang('Toate drepturile rezervate.')
        </p>
    </div>
</footer>
