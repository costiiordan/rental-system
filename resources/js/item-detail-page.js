'use strict';

import { initAddToCartButtons, initAddToCartContainer, initAddToCartDialog } from './cart-buttons.js';

export function initItemDetailPage() {
    initAddToCartButtons();
    initAddToCartDialog();
    initAddToCartContainer();
}
