document.addEventListener('DOMContentLoaded', () => {
    const form = document.querySelector('.form');
    const passwordField = document.getElementById('password');

    form.addEventListener('submit', (event) => {
        console.log("Submitting");
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

                if (response.status == 401) {
                    alert("Wrong Credentials");
                    return;
                } else if (response.status == 200) {
                    return response.json();
                }
            })
            .then(data => {
                localStorage.setItem('authToken', data.token); // Store token securely
                window.location.href = '/plannerDashboard'
            })
            .catch(error => {
                // Handle error (e.g., show an error message)
                console.error('Error loging:', error);
                alert('Login failed, please try again.');
            });
    });
});
