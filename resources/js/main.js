'use strict';

import { initMobileMenu } from './mobile-menu.js';
import { initCookieConsent } from './cookie-consent.js';

(function () {
    const pageContainer = document.querySelector('[data-role="page-container"]');

    initMobileMenu();
    initCookieConsent();

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
