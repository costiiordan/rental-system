export function initLanguageSwitcher() {
    const languageSwitcher = document.querySelector('[data-action="toggle-language-switcher"]');
    const languageSwitcherDropdown = document.querySelector('[data-role="language-switcher-dropdown"]');

    if (!languageSwitcher || !languageSwitcherDropdown) {
        return;
    }

    languageSwitcher.addEventListener('click', function (event) {
        event.preventDefault();
        languageSwitcherDropdown.classList.toggle('is-open');
    });
}
