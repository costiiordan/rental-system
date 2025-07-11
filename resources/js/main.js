'use strict';

(function() {
    const pageContainer = document.querySelector('[data-role="page-container"]');

    if (!pageContainer) {
        return;
    }

    const route = pageContainer.dataset.route;

    if (route === 'home') {
        import('./homePage.js').then(module => {
            module.initHomePage();
        });
    }

    if (route === 'checkout.index') {
        import('./checkout.js').then(module => {
            module.initCheckoutPage();
        });
    }
})();



