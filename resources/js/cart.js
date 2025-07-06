import { getCsrfToken } from './common.js';

export function initCartPreview() {
    const cartPreviewContainer = document.querySelector('[data-role="cart-preview"]');

    const toggleCartPreviewButton = cartPreviewContainer.querySelector('[data-action="toggle-cart-preview"]');
    const listContainer = cartPreviewContainer.querySelector('[data-role="cart-items-list-container"]');

    toggleCartPreviewButton.addEventListener('click', toggleCartPreview);

    listContainer.addEventListener('click', function(event) {
        if (event.target.matches('[data-action="remove-cart-item"]')) {
            const id = event.target.getAttribute('data-id');
            removeFromCart(id);
        }
    });

    const cart = JSON.parse(cartPreviewContainer.dataset.cart);

    updateCartPreview(cart);
}

export function addToCart(itemId, fromDate, toDate) {
    const request = new Request('/add-to-cart', {
        method: 'POST',
        headers: new Headers({
            'Content-Type': 'application/json',
            'Accept': 'application/json',
            'X-CSRF-Token': getCsrfToken()
        }),
        body: JSON.stringify({
            itemId,
            fromDate,
            toDate
        })
    });

    fetch(request)
        .then(resp => resp.json().then(data => updateCartPreview(data.cart)))
        .catch(error => console.log('Error:', error));
}

function removeFromCart(id) {
    const request = new Request('/remove-from-cart', {
        method: 'POST',
        headers: new Headers({
            'Content-Type': 'application/json',
            'Accept': 'application/json',
            'X-CSRF-Token': getCsrfToken()
        }),
        body: JSON.stringify({ id })
    });

    fetch(request)
        .then(resp => resp.json().then(data => updateCartPreview(data.cart)))
        .catch(error => console.log('Error:', error));
}

function updateCartPreview(cart) {
    const cartPreviewContainer = document.querySelector('[data-role="cart-preview"]');
    const listContainer = cartPreviewContainer.querySelector('[data-role="cart-items-list-container"]');
    const discountsContainer = cartPreviewContainer.querySelector('[data-role="cart-discounts"]');
    const counter = cartPreviewContainer.querySelector('[data-role="cart-item-count"]');
    const total = cartPreviewContainer.querySelector('[data-role="cart-total"]');

    if (cart.items.length === 0) {
        listContainer.innerHTML = '';
        discountsContainer.innerHTML = '';
        cartPreviewContainer.classList.remove('expanded');

        cartPreviewContainer.style.removeProperty('display');
        counter.innerHTML = '0';

        return;
    }

    let listItems = '';

    cart.items.forEach(item => {console.log(item);
        const itemTemplate = document.getElementById('cart-preview-item-template').innerHTML;
        listItems += itemTemplate
            .replaceAll('{id}', item.id)
            .replaceAll('{name}', item.item.name)
            .replaceAll('{imagePath}', item.item.image_path)
            .replaceAll('{fromDate}', new Date(item.fromDate).toLocaleString('ro-Ro'))
            .replaceAll('{toDate}', new Date(item.toDate).toLocaleString('ro-Ro'))
            .replaceAll('{price}', item.price);
    });

    let discounts = '';

    cart.discounts.forEach(discount => {
        const discountTemplate = document.getElementById('cart-preview-discount-template').innerHTML;
        discounts += discountTemplate
            .replaceAll('{name}', discount.name)
            .replaceAll('{value}', discount.value);
    });

    counter.innerHTML = cart.items.length;
    listContainer.innerHTML = listItems;
    discountsContainer.innerHTML = discounts;
    total.innerHTML = `${cart.total} RON`;

    cartPreviewContainer.style.display = 'block';
}

function toggleCartPreview(event) {
    event.preventDefault();

    const cartPreviewContainer = document.querySelector('[data-role="cart-preview"]');

    cartPreviewContainer.classList.toggle('expanded');
}
