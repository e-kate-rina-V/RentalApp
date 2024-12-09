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
        document.getElementById('nameError').innerText = 'Ім\'я не може бути порожнім.';
        valid = false;
    } else if (name.length < 3) {
        document.getElementById('nameError').innerText = 'Ім\'я має бути не менше 3 символів.';
        valid = false;
    }

    const emailPattern = /^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,6}$/;
    if (email === '') {
        document.getElementById('emailError').innerText = 'Email не може бути порожнім.';
        valid = false;
    } else if (!emailPattern.test(email)) {
        document.getElementById('emailError').innerText = 'Введіть коректний email.';
        valid = false;
    }

    if (password !== '' && password.length < 8) {
        document.getElementById('passwordError').innerText = 'Пароль має бути не менше 8 символів.';
        valid = false;
    }

    if (password !== '' && password !== passwordConfirmation) {
        document.getElementById('passwordConfirmationError').innerText = 'Паролі не співпадають.';
        valid = false;
    }

    if (!valid) {
        event.preventDefault();
    }
});

