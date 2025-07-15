<div class="cookie-consent" data-role="cookie-consent">
    <div class="cookie-consent-content">
        <button class="cookie-consent-accept" data-action="accept-cookies">@lang('Acceptă')</button>
        <button class="cookie-consent-decline" data-action="decline-cookies">@lang('Refuză')</button>
        <p>@lang('Acest site folosește cookie-uri pentru a îmbunătăți experiența utilizatorului.')</p>
        <a href="{{LaravelLocalization::localizeUrl(route('cookie-policy'))}}" class="cookie-policy-link">@lang('Vezi politica de utilizare a cookie-urilor')</a>
    </div>
</div>
