document.addEventListener('DOMContentLoaded', () => {
    const form = document.querySelector('.form');
    const passwordField = document.getElementById('password');
    const confirmPasswordField = document.getElementById('confirm-password');

    console.log(form);

    form.addEventListener('submit', (event) => {
        event.preventDefault();  // Prevent the form from submitting the default way

        const email = document.getElementById('email').value;
        const password = passwordField.value;
        const confirmPassword = confirmPasswordField.value;
        const agree = document.getElementById('agree').checked;
        const newsletter = document.getElementById('newsletter').checked;

        // Check if the passwords match
        if (password !== confirmPassword) {
            alert('Passwords do not match!');
            return;  // Stop the form submission
        }

        if (!agree) {
            alert('You must agree to the terms and conditions!');
            return;  // Stop the form submission
        }
        console.log("Why does this happen");
        // Form data to send
        const formData = {
            email: email,
            password: password,
            subscribeNewsletter: newsletter
        };

        // Send the data using Fetch API
        fetch('/register', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify(formData)
        })
        .then(response => {
            if (!response.ok) {
                throw new Error('Network response was not ok');
            }
            return response.json();
        })
        .then(data => {
            // Handle success (e.g., show a success message or redirect)
            alert('Registration successful!');
            console.log('Success:', data);
        })
        .catch(error => {
            // Handle error (e.g., show an error message)
            console.error('Error registering:', error);
            alert('Registration failed, please try again.');
        });
    });
});
