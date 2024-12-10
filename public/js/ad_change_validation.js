document.getElementById('ad-change').addEventListener('submit', function (event) {
    let valid = true;

    const title = document.getElementById('title').value.trim();
    const guest_count = document.getElementById('guest_count').value.trim();
    const description = document.getElementById('description').value.trim();
    const price = document.getElementById('price').value.trim();

    document.getElementById('titleError').innerText = '';
    document.getElementById('guestCountError').innerText = '';
    document.getElementById('descriptionError').innerText = '';
    document.getElementById('priceError').innerText = '';


    if (title === '' || title.length <= 4) {
        document.getElementById('titleError').innerText = 'The title must be at least 5 characters.';
        valid = false;
    }

    if (guest_count === '' || guest_count <= 0) {
        document.getElementById('guestCountError').innerText = 'The number of guests must be at least 1.';
        valid = false;
    }

    if (description === '' || description.length <= 4) {
        document.getElementById('descriptionError').innerText = 'The description must be at least 5 characters.';
        valid = false;
    }

    if (price === '' || price <= 0) {
        document.getElementById('priceError').innerText = 'The price must be greater than zero.';
        valid = false;
    }

    if (!valid) {
        event.preventDefault();
    }
});