import moment from 'moment';
import { getCsrfToken, getLang } from './common.js';

export function initCartPreview() {
    const cartPreviewContainer = document.querySelector('[data-role="cart-preview"]');

    if (!cartPreviewContainer) {
        return;
    }

    const listContainer = cartPreviewContainer.querySelector('[data-role="cart-items-list-container"]');
    const toggleCartPreviewButton = document.querySelector('[data-action="toggle-cart-preview"]');

    listContainer.addEventListener('click', function (event) {
        if (event.target.matches('[data-action="remove-cart-item"]')) {
            const id = event.target.getAttribute('data-id');
            removeFromCart(id);
        }
    });

    toggleCartPreviewButton.addEventListener('click', function(event) {
        event.preventDefault();
        cartPreviewContainer.classList.toggle('is-open')
    });

    updateCartPreview();

    document.addEventListener('cartUpdated', (event) => {
        updateCartPreview();

        if (event.detail.action === 'add') {
            document.querySelector('[data-role="add-to-cart-dialog"]').showModal();
        }
    });
}

export async function addToCart(itemId, fromDate, toDate) {
    const request = new Request('/add-to-cart', {
        method: 'POST',
        headers: new Headers({
            'Content-Type': 'application/json',
            Accept: 'application/json',
            'X-CSRF-Token': getCsrfToken(),
        }),
        body: JSON.stringify({
            itemId,
            fromDate,
            toDate,
        }),
    });

    const resp = await fetch(request);
    const respJson = await resp.json();

    window.rental.cart = respJson.cart;

    const event = new CustomEvent('cartUpdated', {
        detail: {
            action: 'add',
            itemId: itemId,
            cartItemId: respJson.cartItemId,
            cart: respJson.cart,
        },
    });
    document.dispatchEvent(event);

    return respJson;
}

export async function removeFromCart(id) {
    const itemId = window.rental.cart.items.find(cartItem => cartItem.id === id)?.item.id;

    const request = new Request('/remove-from-cart', {
        method: 'POST',
        headers: new Headers({
            'Content-Type': 'application/json',
            Accept: 'application/json',
            'X-CSRF-Token': getCsrfToken(),
        }),
        body: JSON.stringify({ id }),
    });

    const resp = await fetch(request);
    const respJson = await resp.json();

    window.rental.cart = respJson.cart;

    const event = new CustomEvent('cartUpdated', {
        detail: {
            action: 'remove',
            itemId: itemId,
            cartItemId: id,
            cart: respJson.cart,
        },
    });
    document.dispatchEvent(event);

    return respJson;
}

function updateCartPreview() {
    const cart = window.rental?.cart;

    if (!cart) {
        console.warn('Cart data is not available.');
        return;
    }

    const cartPreviewContainer = document.querySelector('[data-role="cart-preview"]');
    const listContainer = cartPreviewContainer.querySelector('[data-role="cart-items-list-container"]');
    const discountsContainer = cartPreviewContainer.querySelector('[data-role="cart-discounts"]');
    const total = cartPreviewContainer.querySelector('[data-role="cart-total"]');
    const emptyCartMessage = cartPreviewContainer.querySelector('[data-role="empty-cart-message"]');
    const cartPreviewBody = cartPreviewContainer.querySelector('[data-role="cart-preview-body"]');
    const cartPreviewFooter = cartPreviewContainer.querySelector('[data-role="cart-preview-footer"]');

    const cartItemsCount = document.querySelector('[data-role="cart-items-count"]');

    if (cart.items.length === 0) {
        listContainer.innerHTML = '';
        discountsContainer.innerHTML = '';
        cartItemsCount.innerHTML = '';
        total.innerHTML = `${cart.total}`;

        emptyCartMessage.style.display = 'block';
        cartPreviewBody.style.display = 'none';
        cartPreviewFooter.style.display = 'none';

        return;
    }

    let listItems = '';
    const lang = getLang();

    cart.items.forEach((item) => {
        const itemTemplate = document.getElementById('cart-preview-item-template').innerHTML;
        const fromDate = moment(item.fromDate).format('DD.MM HH:mm');
        const toDate = moment(item.toDate).format('DD.MM HH:mm');
        listItems += itemTemplate
            .replaceAll('{id}', item.id)
            .replaceAll('{name}', item.item.name[lang])
            .replaceAll('{imagePath}', item.item.image_path)
            .replaceAll('{fromDate}', fromDate)
            .replaceAll('{toDate}', toDate)
            .replaceAll('{price}', item.price);
    });

    let discounts = '';

    cart.discounts.forEach((discount) => {
        const discountTemplate = document.getElementById('cart-preview-discount-template').innerHTML;
        discounts += discountTemplate.replaceAll('{name}', discount.name).replaceAll('{value}', discount.value);
    });

    cartItemsCount.innerHTML = cart.items.length;
    listContainer.innerHTML = listItems;
    discountsContainer.innerHTML = discounts;
    total.innerHTML = `${cart.total}`;

    emptyCartMessage.style.display = 'none';
    cartPreviewBody.style.display = 'block';
    cartPreviewFooter.style.display = 'block';
}
