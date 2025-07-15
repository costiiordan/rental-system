const COOKIE_CONSENT_KEY = 'cookie_consent';
const COOKIE_CONSENT_ACCEPTED = 'accepted';
const COOKIE_CONSENT_DECLINED = 'declined';
const SHOW_COOKIE_CONSENT_TIMEOUT = 1000;
const ANIMATION_DURATION = 300;

export function initCookieConsent() {
    const cookieConsent = document.querySelector('[data-role="cookie-consent"]');

    if (localStorage.getItem(COOKIE_CONSENT_KEY) !== null) {
        cookieConsent.remove();

        return;
    }

    showCookieConsent(cookieConsent);
    attachEvents(cookieConsent);
}

export function isCookieConsentAccepted() {
    return localStorage.getItem(COOKIE_CONSENT_KEY) === COOKIE_CONSENT_ACCEPTED;
}

function showCookieConsent(cookieConsent) {
    setTimeout(() => {
        cookieConsent.classList.add('is-present');

        setTimeout(() => {
            cookieConsent.classList.add('is-visible');
        }, 50);
    }, SHOW_COOKIE_CONSENT_TIMEOUT);
}

function hideCookieConsent(cookieConsent) {
    cookieConsent.classList.remove('is-visible');
    setTimeout(() => {
        cookieConsent.remove();
    }, ANIMATION_DURATION);
}

function attachEvents(cookieConsent) {
    const acceptButton = cookieConsent.querySelector('[data-action="accept-cookies"]');
    const declineButton = cookieConsent.querySelector('[data-action="decline-cookies"]');

    acceptButton.addEventListener('click', function () {
        localStorage.setItem(COOKIE_CONSENT_KEY, COOKIE_CONSENT_ACCEPTED);

        hideCookieConsent(cookieConsent);
    });

    declineButton.addEventListener('click', function () {
        localStorage.setItem(COOKIE_CONSENT_KEY, COOKIE_CONSENT_DECLINED);

        hideCookieConsent(cookieConsent);
    });
}
