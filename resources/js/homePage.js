import { addToCart, initCartPreview } from './cart.js';

export function initHomePage() {
    const addToCartButtons = document.querySelectorAll('[data-action="add-to-cart"]');

    addToCartButtons.forEach(button => {
        button.addEventListener('click', handleAddToCartButtonClick);
    });

    initCartPreview();
}

function handleAddToCartButtonClick(event) {
    event.preventDefault();
    const itemId = this.getAttribute('data-item-id');
    const fromDate = this.getAttribute('data-from');
    const toDate = this.getAttribute('data-to');

    addToCart(itemId, fromDate, toDate);
}
