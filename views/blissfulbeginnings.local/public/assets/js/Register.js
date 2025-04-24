document.addEventListener('DOMContentLoaded', () => {
    const form = document.querySelector('.form');
    const passwordField = document.getElementById('password');
    const confirmPasswordField = document.getElementById('confirm-password');

    form.addEventListener('submit', (event) => {
        event.preventDefault();  // Prevent the form from submitting the default way

        const email = document.getElementById('email').value.toLowerCase();
        const emailPattern = /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.com$/i;

        if (!emailPattern.test(email)) {
            alert('Please enter a valid email address ending with .com');
            return;
        }
        const password = passwordField.value;
        const confirmPassword = confirmPasswordField.value;
        const agree = document.getElementById('agree').checked;
        const newsletter = document.getElementById('newsletter').checked;

        const emailPattern = /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.com$/i;

        if (!emailPattern.test(email)) {
            alert('Please enter a valid email address ending with .com (e.g., example@domain.com)');
            return;
        }
        form.reset();
        // Check if the passwords match
        if (password !== confirmPassword) {
            alert('Passwords do not match!');
            return;  // Stop the form submission
        }

        if (!agree) {
            alert('You must agree to the terms and conditions!');
            return;  // Stop the form submission
        }
        // Form data to send
        const formData = {
            email: email,
            
            password: password,
            subscribeNewsletter: newsletter
        };

        // Send the data using Fetch API
        fetch('/BlissfulBeginnings/register', {
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
            if (data.token) {
                localStorage.setItem('authToken', data.token); // Store token securely
                window.location.href = '/wedding-details/' + data.userID;
              } else {
                console.error('Login failed');
              }
        })
        .catch(error => {
            // Handle error (e.g., show an error message)
            console.error('Error registering:', error);
        });
    });
});
