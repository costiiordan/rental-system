export function initMobileMenu() {
    const mobileMenuButton = document.querySelector('[data-action="toggle-mobile-menu"]');
    const closeMobileMenuButton = document.querySelector('[data-action="close-mobile-menu"]');

    mobileMenuButton.addEventListener('click', function (event) {
        event.preventDefault();
        const mobileMenu = document.querySelector('[data-role="mobile-menu"]');
        if (mobileMenu) {
            mobileMenu.classList.toggle('is-open');
        }
    });

    closeMobileMenuButton.addEventListener('click', function (event) {
        event.preventDefault();
        const mobileMenu = document.querySelector('[data-role="mobile-menu"]');
        if (mobileMenu) {
            mobileMenu.classList.remove('is-open');
        }
    });
}
