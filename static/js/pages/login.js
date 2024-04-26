function submitForm(event) {
    console.log('Submitting form');
    event.preventDefault();

    var email = document.getElementById('email').value;
    var password = document.getElementById('password').value;

    fetch('/admin/api/login', {
        method: 'POST',
        body: JSON.stringify({
            email: email,
            password: password
        }),
        headers: {
            'Content-Type': 'application/json'
        }
    }).then(function(response) {
        if (response.ok) {
            console.log('Login successful');
            window.location.href = '/admin/dashboard';
        } else {
            swal('Login failed', 'Please check your email and password and try again.', 'error');
            console.log('Login failed');
        }
    });
}

document.getElementById('loginForm').addEventListener('submit', submitForm);
