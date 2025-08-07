'use strict';

import 'zoom-vanilla.js/dist/zoom-vanilla.min.js';
import { addToCart, removeFromCart } from './cart.js';
import { initRangeSelector } from './range-selector.js';
import moment from 'moment';

export function initHomePage() {
    const addToCartButtons = document.querySelectorAll('[data-action="add-to-cart"]');
    const removeFromCartButtons = document.querySelectorAll('[data-action="remove-from-cart"]');

    addToCartButtons.forEach((button) => {
        button.addEventListener('click', handleAddToCartButtonClick);
    });
    removeFromCartButtons.forEach((button) => {
        button.addEventListener('click', handleRemoveFromCartButtonClick);
    });

    // initRangeSelector();

    initAddToCartContainer();

    const addToCartConfirmationDialog = document.querySelector('[data-role="add-to-cart-dialog"]');
    addToCartConfirmationDialog.querySelector('[data-action="close-dialog"]').addEventListener('click', function () {
        addToCartConfirmationDialog.close();
    });

    document.addEventListener('cartUpdated', (event) => {
        let action;

        if (event.detail.action === 'add') {
            action = 'showRemoveFromCart';
        } else if (event.detail.action === 'remove') {
            action = 'showAddToCart';
        } else {
            console.error('Unknown cart action:', event.detail.action);
            return;
        }

        toggleAddRemoveCartButton(action, event.detail.itemId, event.detail.cartItemId);
    });
}

async function handleAddToCartButtonClick(event) {
    event.preventDefault();
    event.target.setAttribute('disabled', '');
    event.target.classList.add('btn-loading')

    const itemId = this.dataset.itemId;
    const fromDate = this.dataset.from;
    const toDate = this.dataset.to;

    const cart = await addToCart(itemId, fromDate, toDate);

    toggleAddRemoveCartButton('showRemoveFromCart', itemId, cart.cartItemId);

    event.target.removeAttribute('disabled');
    event.target.classList.remove('btn-loading');
}

async function handleRemoveFromCartButtonClick(event) {
    event.preventDefault();
    event.target.setAttribute('disabled', '');
    event.target.classList.add('btn-loading')

    const cartItemId = this.dataset.cartItemId;

    await removeFromCart(cartItemId);

    const itemId = event.target.closest('[data-role="add-to-cart-container"]').dataset.itemId;

    toggleAddRemoveCartButton('showAddToCart', itemId);

    event.target.removeAttribute('disabled');
    event.target.classList.remove('btn-loading');
}

function initAddToCartContainer() {
    const cart = window.rental?.cart;
    const interval = window.rental?.interval;

    if (!cart || !interval) {
        return;
    }

    const selectedFromDate = moment(interval.from);
    const selectedToDate = moment(interval.to);

    cart.items.forEach((cartItem) => {
        const cartItemFromDate = moment(cartItem.fromDate);
        const cartItemToDate = moment(cartItem.toDate);

        const isIntervalOverlapping = selectedFromDate.isSameOrBefore(cartItemToDate) && cartItemFromDate.isSameOrBefore(selectedToDate);

        const action = isIntervalOverlapping ? 'showRemoveFromCart' : 'showAddToCart';

        toggleAddRemoveCartButton(action, cartItem.item.id, cartItem.id);
    });

    document.querySelectorAll('[data-role="add-to-cart-container"]:not(.show-remove-from-cart)')
        .forEach((container) => {
            container.classList.add('show-add-to-cart');
        });
}

function toggleAddRemoveCartButton(action, itemId, cartItemId) {
    const addToCartContainer = document.querySelector(`[data-role="add-to-cart-container"][data-item-id="${itemId}"]`);

    if (!addToCartContainer) {
        return;
    }

    addToCartContainer.classList.remove('initial-state');

    if (action === 'showAddToCart') {
        addToCartContainer.classList.add('show-add-to-cart');
        addToCartContainer.classList.remove('show-remove-from-cart');
    } else if (action === 'showRemoveFromCart') {
        addToCartContainer.classList.remove('show-add-to-cart');
        addToCartContainer.classList.add('show-remove-from-cart');
        addToCartContainer
            .querySelector('[data-role="remove-from-cart"]')
            .dataset.cartItemId = cartItemId;
    }
}
