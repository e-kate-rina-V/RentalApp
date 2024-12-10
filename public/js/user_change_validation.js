document.getElementById('user-change').addEventListener('submit', function (event) {
    let valid = true;

    const name = document.getElementById('name').value.trim();
    const email = document.getElementById('email').value.trim();
    const password = document.getElementById('password').value.trim();
    const passwordConfirmation = document.getElementById('password_confirmation').value.trim();

    document.getElementById('nameError').innerText = '';
    document.getElementById('emailError').innerText = '';
    document.getElementById('passwordError').innerText = '';
    document.getElementById('passwordConfirmationError').innerText = '';

    if (name === '') {
        document.getElementById('nameError').innerText = 'The name cannot be empty.';
        valid = false;
    } else if (name.length < 2) {
        document.getElementById('nameError').innerText = 'The name cannot be less than 2 characters.';
        valid = false;
    }

    const emailPattern = /^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,6}$/;
    if (email === '') {
        document.getElementById('emailError').innerText = 'The email cannot be empty.';
        valid = false;
    } else if (!emailPattern.test(email)) {
        document.getElementById('emailError').innerText = 'Please input an correct email.';
        valid = false;
    }

    if (password !== '' && password.length < 8) {
        document.getElementById('passwordError').innerText = 'The password must contain at least 8 characters';
        valid = false;
    } else if (password !== '' && (!/[a-zA-Z]/.test(password) || !/[0-9]/.test(password))) {
        document.getElementById('passwordError').innerText = 'Password must contain at least one letter and one number.'
        valid = false;
    }

    if (password !== '' && password !== passwordConfirmation) {
        document.getElementById('passwordConfirmationError').innerText = 'Passwords do not match.';
        valid = false;
    }

    if (!valid) {
        event.preventDefault();
    }
});

