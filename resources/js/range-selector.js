
let rangeSelector, rangeSelectorForm;

export function initRangeSelector() {
    rangeSelector = document.querySelector('[data-role="range-selector"]');
    rangeSelectorForm = rangeSelector.querySelector('[data-role="range-selector-form"]');

    window.addEventListener('scroll', onScrollBelowElement);
    onScrollBelowElement();
}

function onScrollBelowElement() {
    const rect = rangeSelector.getBoundingClientRect();
    const scrolledBelow = rect.top < 0;

    if (scrolledBelow) {
        stickyRangeSelector();
    } else {
        unstickyRangeSelector();
    }
}

function stickyRangeSelector() {
    if (rangeSelectorForm.classList.contains('is-sticky')) {
        return;
    }

    rangeSelector.style.height = `${rangeSelector.offsetHeight}px`;
    rangeSelectorForm.classList.add('is-sticky');
}

function unstickyRangeSelector() {
    if (!rangeSelectorForm.classList.contains('is-sticky')) {
        return;
    }

    rangeSelectorForm.classList.remove('is-sticky');
    rangeSelector.style.height = 'auto';
}
