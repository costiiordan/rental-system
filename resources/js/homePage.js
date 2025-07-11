'use strict';

import { addToCart, initCartPreview } from './cart.js';
import 'zoom-vanilla.js/dist/zoom-vanilla.min.js';

export function initHomePage() {


    const addToCartButtons = document.querySelectorAll('[data-action="add-to-cart"]');

    addToCartButtons.forEach(button => {
        button.addEventListener('click', handleAddToCartButtonClick);
    });

    initCartPreview();

    const addToCartConfirmationDialog = document.querySelector('[data-role="add-to-cart-dialog"]');
    addToCartConfirmationDialog.querySelector('[data-action="close-dialog"]').addEventListener('click', function() {
        addToCartConfirmationDialog.close();
    });
}

function handleAddToCartButtonClick(event) {
    event.preventDefault();
    const itemId = this.getAttribute('data-item-id');
    const fromDate = this.getAttribute('data-from');
    const toDate = this.getAttribute('data-to');

    addToCart(itemId, fromDate, toDate);
}
