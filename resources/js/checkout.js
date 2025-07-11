export function initCheckoutPage() {
    const viewCartButton = document.querySelector('[data-action="toggle-cart-preview"]');

    viewCartButton.addEventListener('click', function(event) {
        event.preventDefault();

        viewCartButton.classList.toggle('expanded');
        document.querySelector('[data-role="checkout-cart-container"]').classList.toggle('expanded');
    });
}
