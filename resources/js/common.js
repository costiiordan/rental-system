export function getCsrfToken() {
    return document.querySelector('meta[name="csrf-token"]').getAttribute('content');
}

export function getLang() {
    return document.documentElement.lang || 'ro';
}


