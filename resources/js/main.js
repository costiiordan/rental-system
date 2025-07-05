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

    function showSelectedItems(selectedItems) {
        const selectedItemsContainer = document.getElementById('selected-items-container');
        const listContainer = selectedItemsContainer.querySelector('[data-role="list-container"]');
        const counter = selectedItemsContainer.querySelector('#selected-products-counter');

        if (selectedItems.length === 0) {
            listContainer.innerHTML = '';
            selectedItemsContainer.classList.remove('expanded');

            selectedItemsContainer.style.removeProperty('display');
            counter.innerHTML = '0';

            return;
        }

        let listItems = '';

        selectedItems.forEach(item => {console.log(item);
            const itemTemplate = document.getElementById('selected-item-preview-template').innerHTML;
            listItems += itemTemplate
                .replaceAll('{id}', item.id)
                .replaceAll('{name}', item.item.name)
                .replaceAll('{imagePath}', item.item.image_path)
                .replaceAll('{fromDate}', new Date(item.bookingFromDate).toLocaleString('ro-Ro'))
                .replaceAll('{toDate}', new Date(item.bookingToDate).toLocaleString('ro-Ro'))
                .replaceAll('{price}', item.price);


        });

        counter.innerHTML = selectedItems.length;
        listContainer.innerHTML = listItems;

        selectedItemsContainer.style.display = 'block';
    }

    function expandSelectedItems(event) {
        event.preventDefault();

        const selectedItemsContainer = document.getElementById('selected-items-container');

        selectedItemsContainer.classList.toggle('expanded');
    }

    function removeSelectedItem(id) {
        const request = new Request('/remove-selected-item', {
            method: 'POST',
            headers: new Headers({
                'Content-Type': 'application/json',
                'X-CSRF-Token': getCsrfToken()
            }),
            body: JSON.stringify({ id })
        });

        fetch(request)
            .then(resp => {
                console.log('Response:', resp);

                document.dispatchEvent(new CustomEvent('getSelectedItems'));
            })
            .catch(error => console.log('Error:', error));
    }

    function initPage() {
        const selectButtons = document.querySelectorAll('[data-action="select-bike"]');
        const expandSelectedItemsButton = document.getElementById('expand-selected-items');
        const selectedItemsContainer = document.getElementById('selected-items-container');

        selectButtons.forEach(button => {
            button.addEventListener('click', handleSelectButtonClick);
        });

        expandSelectedItemsButton.addEventListener('click', expandSelectedItems);

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
                .then(resp => resp.json().then(data => showSelectedItems(data.selectedItems)))
                .catch(error => console.log('Error:', error));
        });

        document.dispatchEvent(new CustomEvent('getSelectedItems'));

        selectedItemsContainer.addEventListener('click', function(event) {
            if (event.target.matches('[data-action="remove-selected-item"]')) {
                const id = event.target.getAttribute('data-id');
                removeSelectedItem(id);
            }
        });
    }

    initPage();
})();



