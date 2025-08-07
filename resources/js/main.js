'use strict';

import { initMobileMenu } from './mobile-menu.js';
import { initCookieConsent } from './cookie-consent.js';
import { initLanguageSwitcher } from './language-switcher.js';
import { initCartPreview } from './cart.js';

(function () {
    initMobileMenu();
    initLanguageSwitcher();
    initCookieConsent();
    initCartPreview();

    const route = window.rental?.routeName;

    if (!route) {
        return;
    }

    if (route === 'home') {
        import('./home-page.js').then((module) => {
            module.initHomePage();
        });
    }

    if (route === 'checkout.index') {
        import('./checkout.js').then((module) => {
            module.initCheckoutPage();
        });
    }
})();
