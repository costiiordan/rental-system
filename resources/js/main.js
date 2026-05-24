'use strict';

import 'zoom-vanilla.js/dist/zoom-vanilla.min.js';
import { initCartPreview } from './cart.js';
import { initCookieConsent } from './cookie-consent.js';
import { initLanguageSwitcher } from './language-switcher.js';
import { initMobileMenu } from './mobile-menu.js';

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

    if (route === 'item.show') {
        import('./item-detail-page.js').then((module) => {
            module.initItemDetailPage();
        });
    }

    if (route === 'checkout.index') {
        import('./checkout.js').then((module) => {
            module.initCheckoutPage();
        });
    }
})();
