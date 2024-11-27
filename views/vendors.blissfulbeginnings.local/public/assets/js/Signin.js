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
            if(response.status == 500){
                throw new Error('Internal server error');
            }
            return response.json();
        })
        .then(data => {
            // Handle success (e.g., show a success message or redirect)
            console.log('Success:', data);
            localStorage.setItem('authToken', data.token); // Store token securely
            window.location.href = '/vendor/' + data.vendorID;
        })
        .catch(error => {
            // Handle error (e.g., show an error message)
            alert('Error registering:', error);
        });
    });
});
