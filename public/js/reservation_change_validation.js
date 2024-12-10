document.getElementById('reservation-change').addEventListener('submit', function (event) {
    let valid = true;

    const arrival_date = document.getElementById('arrival_date').value.trim();
    const depart_date = document.getElementById('depart_date').value.trim();
    const price = document.getElementById('total_cost').value.trim();

    document.getElementById('arrivalDateError').innerText = '';
    document.getElementById('departDateError').innerText = '';
    document.getElementById('priceError').innerText = '';

    if (arrival_date === '') {
        document.getElementById('arrivalDateError').innerText = 'The date of arrival cannot be empty.';
        valid = false;
    } 

    if (depart_date === '' || new Date(depart_date) < new Date(arrival_date)) {
        document.getElementById('departDateError').innerText = 'The departure date cannot be earlier than the arrival date.';
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