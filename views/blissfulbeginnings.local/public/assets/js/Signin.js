document.addEventListener('DOMContentLoaded', () => {
    const form = document.querySelector('.form');
    const passwordField = document.getElementById('password');

    form.addEventListener('submit', (event) => {
        event.preventDefault();  // Prevent the form from submitting the default way

        const email = document.getElementById('email').value.toLowerCase();
        const password = passwordField.value;

        form.reset();
        const formData = {
            email: email,
            password: password,
        };

        // Send the data using Fetch API
        fetch('/signin', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify(formData)
        })
            .then(response => {
                console.log(response);
                if (!response.ok) {
                    if (response.status == 401) {
                        alert("Wrong credentials");
                        return;
                    } if (response.state = 403) {
                        localStorage.setItem('authToken', data.token); // Store token securely
                        window.location.href = '/wedding-details'
                    }
                    else {
                        throw new Error('Network response was not ok');
                    }
                }
                return response.json();
            })
            .then(data => {
                if (data.token) {
                    localStorage.setItem('authToken', data.token); // Store token securely
                    window.location.href = '/wedding/' + data.weddingID
                } else {
                    console.error('Login failed');
                }
            })
            .catch(error => {
                // Handle error (e.g., show an error message)
                console.error('Error registering:', error);
                alert('SignUp failed, please try again.');
            });
    });
});
