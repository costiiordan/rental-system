(function() {
    'use strict';

    function getCsrfToken() {
        return document.querySelector('meta[name="csrf-token"]').getAttribute('content');
    }

    function handleSelectButtonClick(event) {
        event.preventDefault();
        const itemId = this.getAttribute('data-item-id');
        const fromDateTime = this.getAttribute('data-from');
        const toDateTime = this.getAttribute('data-to');

        const selectEvent = new CustomEvent('itemSelected', {
            detail: {
                itemId,
                fromDateTime,
                toDateTime,
            }
        });

        document.dispatchEvent(selectEvent);
    }

    function initPage() {
        const selectButtons = document.querySelectorAll('[data-action="select-bike"]');

        selectButtons.forEach(button => {
            button.addEventListener('click', handleSelectButtonClick);
        });

        document.addEventListener('itemSelected', function(event) {
            const itemBooking = event.detail;

            const request = new Request('/select-item', {
                method: 'POST',
                headers: new Headers({
                    'Content-Type': 'application/json',
                    'X-CSRF-Token': getCsrfToken()
                }),
                body: JSON.stringify(itemBooking)
            });

            fetch(request)
                .then(resp => {
                    console.log('Response:', resp);

                    document.dispatchEvent(new CustomEvent('getSelectedItems'));
                })
                .catch(error => console.log('Error:', error));
        });

        document.addEventListener('getSelectedItems', function() {
            const request = new Request('/get-selected-items', {
                method: 'GET',
                headers: new Headers({
                    'Content-Type': 'application/json',
                    'X-CSRF-Token': getCsrfToken()
                }),
            });

            fetch(request)
                .then(resp => {
                    console.log('Selected Items:', resp);
                })
                .catch(error => console.log('Error:', error));
        });
    }

    initPage();

    document.getElementById('test_get_selected_items').addEventListener('click', function(event) {
        event.preventDefault();
        document.dispatchEvent(new CustomEvent('getSelectedItems'));
    })
})();



