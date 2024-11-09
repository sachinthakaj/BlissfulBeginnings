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
                if (response.status == 409) {
                    alert("Email is already registered");
                    return;
                } else {
                    throw new Error('Network response was not ok');
                }
            }
            return response.json();
        })
        .then(data => {
            // Handle success (e.g., show a success message or redirect)
            console.log('Success:', data);
            window.location.href = '/dashboard'
        })
        .catch(error => {
            // Handle error (e.g., show an error message)
            console.error('Error registering:', error);
            alert('SignUpfailed, please try again.');
        });
    });
});
