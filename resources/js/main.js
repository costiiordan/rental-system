'use strict';

import { initMobileMenu } from './mobile-menu.js';
import { initCookieConsent } from './cookie-consent.js';
import { initLanguageSwitcher } from './language-switcher.js';
import { initCartPreview } from './cart.js';

(function () {
    const pageContainer = document.querySelector('[data-role="page-container"]');

    initMobileMenu();
    initLanguageSwitcher();
    initCookieConsent();
    initCartPreview();

    if (!pageContainer) {
        return;
    }

    const route = pageContainer.dataset.route;

    if (route === 'home' || route === 'category') {
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
